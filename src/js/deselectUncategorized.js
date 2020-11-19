/**
 * Uncheck and disable default category if another category is checked
 * 
 * @link https://github.com/helgatheviking/Radio-Buttons-for-Taxonomies
 * 
 * @package WordPress
 * @requires wordpress-v5+
 * @see https://github.com/WordPress/gutenberg/blob/master/packages/editor/src/components/post-taxonomies/hierarchical-term-selector.js
 * 
 * @subpackage WPJetFuel
 * @since 2.6.0
 */
(function () {
    function customizeTaxonomySelector(OriginalComponent) {
        return function (props) {
            if (props.slug === 'category') {
                if (!window.deselectUncategorized) {
                    window.deselectUncategorized = class deselectUncategorized extends OriginalComponent {

                        onChange(termId) {
                            const { onUpdateTerms, terms = [], taxonomy } = this.props;
                            const defaultId = parseInt(scriptParams.defaultCategory, 10);
                            const hasTerm = terms.indexOf( termId ) !== -1;
                            let newTerms = hasTerm ?
                                _.without(terms, termId) :
                                [...terms, termId];

                            if (newTerms.length === 0 ) {
                                newTerms = [defaultId];
                            } else if (newTerms.indexOf(defaultId) !== -1) {
                                newTerms = _.without(newTerms, defaultId);
                            }

                            onUpdateTerms(newTerms, taxonomy.rest_base);
                        }
                    };
                }
                return wp.element.createElement(
                    deselectUncategorized,
                    props
                );
            }
            return wp.element.createElement(
                OriginalComponent,
                props
            );
        };
    }
    wp.hooks.addFilter('editor.PostTaxonomyType', 'wp-jet-fuel', customizeTaxonomySelector);
})();
