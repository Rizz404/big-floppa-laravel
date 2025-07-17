<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Theme
    |--------------------------------------------------------------------------
    | The theme to use for SweetAlert2 popups.
    | Available themes: dark, minimal, borderless, bootstrap-4, material-ui, wordpress-admin, bulma.
    |
    */

    'theme' => env('SWEET_ALERT_THEME', 'default'),

    /*
    |--------------------------------------------------------------------------
    | CDN LINK
    |--------------------------------------------------------------------------
    | By default SweetAlert2 use its local sweetalert.all.js
    | file.
    | However, you can use its cdn if you want.
    |
    */

    'cdn' => null,

    /*
    |--------------------------------------------------------------------------
    | Always load the sweetalert.all.js
    |--------------------------------------------------------------------------
    | There might be situations where you will always want the sweet alert
    | js package to be there for you. (for eg. you might use it heavily to
    | show notifications or you might want to use the native js) then this
    | might be handy.
    |
    */

    'alwaysLoadJS' => env('SWEET_ALERT_ALWAYS_LOAD_JS', true),

    /*
    |--------------------------------------------------------------------------
    | Never load the sweetalert.all.js
    |--------------------------------------------------------------------------
    | If you want to handle the sweet alert js package by yourself
    | (for eg. you might want to use laravel mix) then this can be
    | handy.
    |
    | alwaysLoadJs = true  & neverLoadJs = true  => js will not be loaded
    | alwaysLoadJs = true  & neverLoadJs = false => js will be loaded
    | alwaysLoadJs = false & neverLoadJs = false => js will be loaded when
    | you set alert/toast by using the facade/helper functions.
    */

    'neverLoadJS' => env('SWEET_ALERT_NEVER_LOAD_JS', false),

    /*
    |--------------------------------------------------------------------------
    | AutoClose Timer
    |--------------------------------------------------------------------------
    |
    | This is for the all Modal windows.
    | For specific modal just use the autoClose() helper method.
    |
    */

    'timer' => env('SWEET_ALERT_TIMER', 5000),

    /*
    |--------------------------------------------------------------------------
    | Width
    |--------------------------------------------------------------------------
    |
    | Modal window width, including paddings (box-sizing: border-box).
    | Can be in px or %.
    | The default width is 32rem.
    | This is for the all Modal windows.
    | for particular modal just use the width() helper method.
    */

    'width' => env('SWEET_ALERT_WIDTH', '32rem'),

    /*
    |--------------------------------------------------------------------------
    | Height Auto
    |--------------------------------------------------------------------------
    | By default, SweetAlert2 sets html's and body's CSS height to auto !important.
    | If this behavior isn't compatible with your project's layout,
    | set heightAuto to false.
    |
    */

    'height_auto' => env('SWEET_ALERT_HEIGHT_AUTO', true),

    /*
    |--------------------------------------------------------------------------
    | Padding
    |--------------------------------------------------------------------------
    |
    | Modal window padding.
    | Can be in px or %.
    | The default padding is 1.25rem.
    | This is for the all Modal windows.
    | for particular modal just use the padding() helper method.
    */

    'padding' => env('SWEET_ALERT_PADDING', '1.25rem'),

    /*
    |--------------------------------------------------------------------------
    | Background
    |--------------------------------------------------------------------------
    |
    |  Modal window background
    |   (CSS background property).
    |  The default background is '#fff'.
    */

    'background' => env('SWEET_ALERT_BACKGROUND', '#fff'),

    /*
    |--------------------------------------------------------------------------
    | Animation
    |--------------------------------------------------------------------------
    | Custom animation with [Animate.css](https://daneden.github.io/animate.css/)
    | If set to false, modal CSS animation will be use default ones.
    | For specific modal just use the animation() helper method.
    |
    */

    'animation' => [
        'enable' => env('SWEET_ALERT_ANIMATION_ENABLE', false),
    ],

    'animatecss' => env('SWEET_ALERT_ANIMATECSS', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css'),

    /*
    |--------------------------------------------------------------------------
    | ShowConfirmButton
    |--------------------------------------------------------------------------
    | If set to false, a "Confirm"-button will not be shown.
    | It can be useful when you're using custom HTML description.
    | This is for the all Modal windows.
    | For specific modal just use the showConfirmButton() helper method.
    |
    */

    'show_confirm_button' => env('SWEET_ALERT_CONFIRM_BUTTON', true),

    /*
    |--------------------------------------------------------------------------
    | ShowCloseButton
    |--------------------------------------------------------------------------
    | If set to true, a "Close"-button will be shown,
    | which the user can click on to dismiss the modal.
    | This is for the all Modal windows.
    | For specific modal just use the showCloseButton() helper method.
    |
    */

    'show_close_button' => env('SWEET_ALERT_CLOSE_BUTTON', false),

    /*
    |-----------------------------------------------------------------------
    | Confirm/Cancel Button Text
    |-----------------------------------------------------------------------
    | Change the default text of the modal buttons.
    | The texts translations will be handled by Laravel at runtime.
    | This is for the all Modal windows.
    | For specific modal just use the confirmButtonText() and
    | cancelButtonText() helper methods.
    */

    'button_text' => [
        'confirm' => env('SWEET_ALERT_CONFIRM_BUTTON_TEXT', 'OK'),
        'cancel' => env('SWEET_ALERT_CANCEL_BUTTON_TEXT', 'Cancel'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Toast position
    |--------------------------------------------------------------------------
    | Modal window or toast position, can be 'top',
    | 'top-start', 'top-end', 'center', 'center-start',
    | 'center-end', 'bottom', 'bottom-start', or 'bottom-end'.
    | For specific modal just use the position() helper method.
    |
    */

    'toast_position' => env('SWEET_ALERT_TOAST_POSITION', 'top-end'),

    /*
    |--------------------------------------------------------------------------
    | Progress Bar
    |--------------------------------------------------------------------------
    | If set to true, a progress bar at the bottom of a popup will be shown.
    | It can be useful with toasts.
    |
    */

    'timer_progress_bar' => env('SWEET_ALERT_TIMER_PROGRESS_BAR', true),

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    | Modal window or toast, config for the Middleware
    |
    */

    'middleware' => [

        'autoClose' => env('SWEET_ALERT_MIDDLEWARE_AUTO_CLOSE', false),

        'toast_position' => env('SWEET_ALERT_MIDDLEWARE_TOAST_POSITION', 'top-end'),

        'toast_close_button' => env('SWEET_ALERT_MIDDLEWARE_TOAST_CLOSE_BUTTON', true),

        'timer' => env('SWEET_ALERT_MIDDLEWARE_ALERT_CLOSE_TIME', 6000),

        'auto_display_error_messages' => env('SWEET_ALERT_AUTO_DISPLAY_ERROR_MESSAGES', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Class
    |--------------------------------------------------------------------------
    | A custom CSS class for the modal:
    |
    */

    'customClass' => [

        'container' => null,
        'popup' => 'card animate-fade-in', // Menggunakan .card dan animasi .animate-fade-in
        'header' => 'card-header',
        'title' => 'text-2xl font-display text-neutral-800', // Menggunakan utility class
        'closeButton' => 'btn-reset alert-dismiss', // Menggunakan .btn-reset dan .alert-dismiss
        'icon' => null,
        'image' => 'max-w-full h-auto rounded-md',
        'content' => 'card-body',
        'input' => 'form-input',
        'actions' => 'card-footer justify-end flex gap-2', // Menambahkan flexbox untuk tombol
        'confirmButton' => 'btn btn-primary', // Menggunakan komponen .btn
        'cancelButton' => 'btn btn-ghost', // Menggunakan komponen .btn
        'footer' => 'text-sm text-neutral-500',
    ],

    /*
    |--------------------------------------------------------------------------
    | confirmDelete
    |--------------------------------------------------------------------------
    | customize the configuration options of the confirmation popup.
    |
    */

    'confirm_delete_confirm_button_text' => env('SWEET_ALERT_CONFIRM_DELETE_CONFIRM_BUTTON_TEXT', 'Yes, delete it!'),
    'confirm_delete_confirm_button_color' => env('SWEET_ALERT_CONFIRM_DELETE_CONFIRM_BUTTON_COLOR'),
    'confirm_delete_cancel_button_color' => env('SWEET_ALERT_CONFIRM_DELETE_CANCEL_BUTTON_COLOR', '#d33'),
    'confirm_delete_cancel_button_text' => env('SWEET_ALERT_CONFIRM_DELETE_CANCEL_BUTTON_TEXT', 'Cancel'),
    'confirm_delete_show_cancel_button' => env('SWEET_ALERT_CONFIRM_DELETE_SHOW_CANCEL_BUTTON', true),
    'confirm_delete_show_close_button' => env('SWEET_ALERT_CONFIRM_DELETE_SHOW_CLOSE_BUTTON', false),
    'confirm_delete_icon' => env('SWEET_ALERT_CONFIRM_DELETE_ICON', 'warning'),
    'confirm_delete_show_loader_on_confirm' => env('SWEET_ALERT_CONFIRM_DELETE_SHOW_LOADER_ON_CONFIRM', true),


];
