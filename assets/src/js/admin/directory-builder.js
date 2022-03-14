// CSS
import './../../scss/admin/directory-builder.scss';

// JS
import './admin-main';

const tasks = {
    init: function() {
        this.setupTranslationLinksToDirectoryType();
    },

    // setupTranslationLinksToDirectoryType
    setupTranslationLinksToDirectoryType: function() {
        const self = this;
        let url = directory_builder_script_data.ajax_url;
        const formData = {
            action: 'get_directory_type_translations',
            directorist_nonce: directory_builder_script_data.directorist_nonce,
        };

        const queryStrings = new URLSearchParams( formData ).toString();
        url = url + '?' + queryStrings;

        fetch( url )
            .then( response => response.json() )
            .then( response => {

                if ( ! response.success ) {
                    console.log( { response } );
                    return;
                }

                self.addTranslationLinksToDirectoryType( response.data );
                self.attachAddTranslationActionHandler();
            })
            .catch( error => {
                console.log( { error } );
            });
    },

    // addTranslationLinksToDirectoryType
    addTranslationLinksToDirectoryType: function( data ) {
        if ( ! data ) {
            return;
        }

        if ( ! data.translation_edit_link_template ) {
            return;
        }

        if ( ! data.translations ) {
            return;
        }

        if ( ! data.wpml_active_languages ) {
            return;
        }
        
        const currentLanguage = data.wpml_current_language;
        const activeLanguages = data.wpml_active_languages;
        const term_translations = data.translations;

        const actions = document.querySelectorAll( '.directorist_listing-actions' );
        
        // Add Translation Actions
        [ ...actions ].map( item => {
            const parent = item.closest( '.directory-type-row' );
            let termID = parent.getAttribute( 'data-term-id' );
            termID = parseInt( termID );
        
            const translation_button_wrap = document.createElement( 'div' );
            translation_button_wrap.className = 'directorist_more-dropdown';
        
            const translationListItems = Object.keys( activeLanguages ).map( translation_key => {  
                const translation = activeLanguages[ translation_key ];

                if ( currentLanguage === translation_key ) {
                    return '';
                }

                const label               = translation.translated_name;
                const hasTerm             = Object.keys( term_translations ).includes( termID.toString() );
                const termTranslationKeys = ( hasTerm ) ? Object.keys( term_translations[ termID ] ) : [];
                const hasTranslation      = termTranslationKeys.includes( translation_key ) ;
                const iconName            = hasTranslation ? 'fas fa-edit' : 'fas fa-plus';
                const flag                = translation.country_flag_url;
                const translationTermID   = hasTranslation ? term_translations[ termID ][ translation_key ].term_id : 0;
                const link                = hasTranslation ? data.translation_edit_link_template.replace( '__ID__', translationTermID ) : '#';
                const linkClass           = hasTranslation ? '' : ' directorist-link-has-action directorist-wpml-add-translation';
        
                return `<li class="directorist-list-item" data-language-code="${translation_key}">
                    <span class="directorist-list-item-label">
                        <span class="directorist-list-item-icon">
                            <img src="${flag}" />
                        </span>
        
                        ${label}
                    </span>
        
                    <div class="directorist-list-item-actions">
                        <a href="${link}" class="directorist-list-item-action-link directorist-text-right--important${linkClass}">
                            <i class="${iconName}"></i>
                        </a>
                    </div>
                </li>`;
            }).filter( item => item ).join("\n");
        
            const translation_button = `
                <a href="#" class="directorist_btn directorist_btn-primary directorist_more-dropdown-toggle directorist_translation-dropdown-toggle">
                    <i class="fas fa-language"></i>
                </a>
        
                <div class="directorist_more-dropdown-option">
                    <ul>${translationListItems}</ul>
                </div>
            `;
        
            translation_button_wrap.innerHTML = translation_button;
        
            item.prepend( translation_button_wrap );
        });
    },

    // attachAddTranslationActionHandler
    attachAddTranslationActionHandler: function () {
        const links = document.querySelectorAll( '.directorist-wpml-add-translation' );

        [ ...links ].map( link => {
            link.addEventListener( 'click', handleAddTranslationAction );
        });
    },

    // addTranslation
    addTranslation: function ( context, event ) {
        const dropdown = context.closest( '.directorist_more-dropdown-option' );
        dropdown.classList.add( 'active' );

        const isLoading = [ ...context.classList ].includes( 'directorist-is-loading' );

        if ( isLoading ) {
            return;
        }

        const originalContent = context.innerHTML;
        context.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        context.classList.add( 'directorist-is-loading' );

        const directory_type_id = context.closest( '.directory-type-row' ).getAttribute( 'data-term-id' );
        const language_code = context.closest( '.directorist-list-item' ).getAttribute( 'data-language-code' );

        let url = directory_builder_script_data.ajax_url;
        const formData = {
            action: 'create_directory_type_translation',
            directorist_nonce: directory_builder_script_data.directorist_nonce,
            directory_type_id,
            taranslation_language_code: language_code,
        };

        const queryStrings = new URLSearchParams( formData ).toString();
        url = url + '?' + queryStrings;

        fetch( url )
            .then( response => response.json() )
            .then( response => {
                context.classList.remove( 'directorist-is-loading' );

                if ( ! response.success ) {
                    context.innerHTML = originalContent;

                    console.log( { response } );
                    alert( response.message );
                    return;
                }

                context.setAttribute( 'href', response.data.edit_link );
                context.removeEventListener( 'click', handleAddTranslationAction );

                context.classList.remove( 'directorist-link-has-action' );
                context.classList.remove( 'directorist-wpml-add-translation' );

                context.innerHTML = '<i class="fas fa-edit"></i>';
            })
            .catch( error => {
                context.classList.remove( 'directorist-is-loading' );
                context.innerHTML = originalContent;

                console.log( { error } );
            });
    },
};

// Init
tasks.init();

// handleAddTranslationAction
function handleAddTranslationAction( event ) {
    event.preventDefault();
    const context = this;

    setTimeout( function() {
        tasks.addTranslation( context, event )
    }, 0 );
}