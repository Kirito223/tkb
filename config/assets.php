<?php

return [
    // Mặc định sẽ là offline, assets sẽ được load từ local, nếu set offline là false và resource có định
    // nghĩa cdn thì assets sẽ được load từ cdn
    'offline'        => env('ASSETS_OFFLINE', true),
    'enable_version' => env('ASSETS_ENABLE_VERSION', true),
    // Bật hiển thị version, lúc này link tới resource sẽ được nối thêm "?v=1.0" chẳng hạn.
    'version'        => env('ASSETS_VERSION', time()),
    'scripts'        => [
        // Các thư viện js mặc định được sử dụng, là key được định nghĩa trong phần resource bên dưới.
        'js-macdinh',
        'js-dev',
        'js-custom',
        'js-datatable'
    ],
    'styles'         => [
        // Các thư viện css mặc định
        'style-macdinh',
        'style-dev',
        'style-datatable',
    ],
    'resources'      => [
        // Định nghĩa tất cả đường dẫn tới assets.
        'scripts' => [
            // Định nghĩa các thư viện js
            'js-macdinh'   => [
                'use_cdn'  => false,
                // Có cho phép sử dụng cdn hay không, nếu là true thì bạn phải định nghĩa link tới cnd bên dưới
                'location' => 'footer',
                // Vị trí chèn, trên header hay dưới footer, có thể là top hoặc bottom
                'src'      => [
                    'local' => [
                        'public/theme/app-assets/vendors/js/vendors.min.js',                          
                        'public/theme/app-assets/js/core/app-menu.min.js',
                        'public/theme/app-assets/js/core/app.min.js',
                        'public/theme/app-assets/js/scripts/customizer.min.js',
                    ],
                    // Đường dẫn tới thư viện
                ],
            ],
            'js-custom' => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => [   
                        'public/assets/axios/dist/axios.min.js',
                        'public/assets/sweetalert2/dist/sweetalert2.all.min.js',
                        'public/theme/app-assets/vendors/js/forms/select/select2.full.min.js',

                    ],
                ],
            ],
            'js-dev' => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => [
                        'public/dx/js/dx.all.js',                        
                    ],
                ],
            ],
            'js-datatable' => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => [
                        'public/theme/app-assets/vendors/js/tables/datatable/datatables.min.js',
                        'public/theme/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js',
                        'public/theme/app-assets/vendors/js/tables/datatable/dataTables.select.min.js',
                        'public/theme/app-assets/js/scripts/tables/datatables-extensions/datatable-select.min.js',
                        'public/theme/app-assets/vendors/js/tables/datatable/dataTables.keyTable.min.js',
                    ],
                ],
            ],
        ],
        'styles'  => [
            // Định nghĩa các thư viện css
            'style-dev' => [
                'use_cdn'    => false,
                'location'   => 'header',
                'src'        => [
                    'local' => [
                        'public/dx/css/dx.common.css',
                        'public/dx/css/dx.material.blue.light.compact.css',
                    ],
                ],
            ],
            'style-datatable' => [
                'use_cdn'    => false,
                'location'   => 'header',
                'src'        => [
                    'local' => [
                        'public/theme/app-assets/vendors/css/tables/datatable/datatables.min.css',
                        'public/theme/app-assets/vendors/css/tables/datatable/select.dataTables.min.css',
                    ],
                ],
            ],
            'style-macdinh' => [
                'use_cdn'    => false,
                'location'   => 'header',
                'src'        => [
                    'local' => [
                        'public/theme/app-assets/css/vendors.min.css',
                        'public/theme/app-assets/css/app.min.css',
                        'public/theme/app-assets/css/core/menu/menu-types/vertical-menu.min.css',
                        'public/theme/app-assets/css/core/colors/palette-gradient.min.css',
                        'public/theme/app-assets/css/plugins/forms/wizard.min.css',
                        'public/theme/assets/css/style.css',
                        'public/theme/app-assets/vendors/css/forms/selects/select2.min.css',
                    ],
                ],
                'attributes' => [
                ],
            ],
        ],
    ],
];
