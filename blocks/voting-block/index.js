/**
 * Moon or Mars Voting Block
 * 
 * This is a simplified version of the block that doesn't require a build step.
 * It uses the WordPress global variables directly.
 */

(function(wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var el = wp.element.createElement;
    var __ = wp.i18n.__;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody = wp.components.PanelBody;
    
    // Register the block
    registerBlockType('moon-or-mars/voting-block', {
        title: 'Moon or Mars Poll',
        icon: 'chart-pie',
        category: 'widgets',
        description: 'Add a poll asking users if they would rather go to the Moon or Mars.',
        
        // Define the edit function
        edit: function(props) {
            var blockProps = useBlockProps({
                className: 'moon-or-mars-block-editor',
            });
            
            return el('div', blockProps, [
                // Inspector Controls
                el(InspectorControls, { key: 'inspector' },
                    el(PanelBody, { title: __('Poll Settings', 'moon-or-mars') },
                        el('p', {}, __('The poll settings are managed in the MoonOrMars plugin settings page.', 'moon-or-mars')),
                        el('a', { href: '/wp-admin/admin.php?page=moon-or-mars-settings', target: '_blank' },
                            __('Open Settings Page', 'moon-or-mars')
                        )
                    )
                ),
                
                // Block Preview
                el('div', { className: 'moon-or-mars-block-preview' }, [
                    // Header
                    el('div', { className: 'moon-or-mars-block-header', key: 'header' }, [
                        el('h3', {}, __('Moon or Mars Poll', 'moon-or-mars')),
                        el('p', {}, __('This block will display the Moon or Mars voting poll on the front-end.', 'moon-or-mars'))
                    ]),
                    
                    // Content
                    el('div', { className: 'moon-or-mars-block-content', key: 'content' },
                        el('div', { className: 'moon-or-mars-block-options' }, [
                            // Moon Option
                            el('div', { className: 'moon-or-mars-block-option moon', key: 'moon' }, [
                                el('div', { className: 'moon-or-mars-block-option-image' },
                                    el('svg', { className: 'moon-svg', viewBox: '0 0 100 100', xmlns: 'http://www.w3.org/2000/svg' }, [
                                        el('circle', { cx: '50', cy: '50', r: '45', fill: '#E6E6E6', key: 'c1' }),
                                        el('circle', { cx: '35', cy: '40', r: '7', fill: '#D3D3D3', key: 'c2' }),
                                        el('circle', { cx: '65', cy: '30', r: '10', fill: '#D3D3D3', key: 'c3' }),
                                        el('circle', { cx: '55', cy: '60', r: '12', fill: '#D3D3D3', key: 'c4' }),
                                        el('circle', { cx: '25', cy: '65', r: '5', fill: '#D3D3D3', key: 'c5' }),
                                        el('circle', { cx: '80', cy: '50', r: '6', fill: '#D3D3D3', key: 'c6' })
                                    ])
                                ),
                                el('h4', {}, __('The Moon', 'moon-or-mars'))
                            ]),
                            
                            // Mars Option
                            el('div', { className: 'moon-or-mars-block-option mars', key: 'mars' }, [
                                el('div', { className: 'moon-or-mars-block-option-image' },
                                    el('svg', { className: 'mars-svg', viewBox: '0 0 100 100', xmlns: 'http://www.w3.org/2000/svg' }, [
                                        el('circle', { cx: '50', cy: '50', r: '45', fill: '#CF3A24', key: 'c1' }),
                                        el('ellipse', { cx: '35', cy: '40', rx: '12', ry: '7', fill: '#A52A2A', key: 'e1' }),
                                        el('ellipse', { cx: '65', cy: '30', rx: '10', ry: '5', fill: '#A52A2A', key: 'e2' }),
                                        el('circle', { cx: '55', cy: '60', r: '12', fill: '#A52A2A', key: 'c2' }),
                                        el('circle', { cx: '25', cy: '65', r: '5', fill: '#A52A2A', key: 'c3' }),
                                        el('circle', { cx: '80', cy: '50', r: '6', fill: '#A52A2A', key: 'c4' }),
                                        el('circle', { cx: '45', cy: '20', r: '15', fill: '#B22222', key: 'c5' })
                                    ])
                                ),
                                el('h4', {}, __('Mars', 'moon-or-mars'))
                            ])
                        ])
                    )
                ])
            ]);
        },
        
        // Define the save function
        save: function() {
            // This block is rendered dynamically on the server, so we return null here
            return null;
        }
    });
})(window.wp);
