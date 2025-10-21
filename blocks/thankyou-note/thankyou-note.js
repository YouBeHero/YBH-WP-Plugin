const { __ } = wp.i18n;
const { createHigherOrderComponent } = wp.compose;
const { addFilter } = wp.hooks;
const { Fragment, createElement } = wp.element;

const withYbhThankyouNote = createHigherOrderComponent((BlockListBlock) => {
    return (props) => {
        if (props.name === 'woocommerce/order-confirmation-totals') {
            return createElement(
                Fragment,
                {},
                createElement(BlockListBlock, props),

                createElement(
                    'div',
                    {
                        className: 'ybh-thankyou-note',
                        style: {
                            marginTop: '20px',
                            fontSize: '18px',
                            padding: '5px 20px',
                            background: '#f9f9f9',
                            borderLeft: '4px solid #0073aa',
                        }
                    },
                    [
                        // Title
                        createElement(
                            'p',
                            {},
                            createElement('strong', {}, __( 'YouBeHero Donation', 'youbehero' ))
                        ),

                        // Paragraph 1
                        createElement(
                            'p',
                            {},
                            __( 'YouBeHero Order Confirmation widget will reside here.', 'youbehero' )
                        ),

                        // Paragraph 2 with link
                        createElement(
                            'p',
                            {},
                            createElement(
                                Fragment,
                                {},
                                __( 'To toggle the visibility of this widget go to', 'youbehero' ),
                                ' ',
                                createElement(
                                    'a',
                                    {
                                        href: 'https://dev.youbehero.com/gr/widget-confirmation-page',
                                        target: '_blank',
                                        rel: 'noopener noreferrer',
                                        className: 'ybhd-link'
                                    },
                                    __( 'this page', 'youbehero' )
                                )
                            )
                        )
                    ]
                )
            );
        }

        return createElement(BlockListBlock, props);
    };
}, 'withYbhThankyouNote');

addFilter(
    'editor.BlockListBlock',
    'ybhd/thankyou-note',
    withYbhThankyouNote
);
