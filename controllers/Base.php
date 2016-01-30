<?php

namespace Controllers;

/**
 * Base class for Wordpress Admin pages
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
abstract class Base {

    /**
     * Data to be passed to the view
     * @var array [$varname => $value]
     */
    protected $data = [];

    /**
     *
     * @var \Illuminate\Support\MessageBag
     */
    protected $errors = null;

    /**
     * App input
     * @var \Illuminate\Http\Request
     */
    protected $input = null;

    /**
     * Plugin refference
     * @var \App\Admin\Plugin 
     */
    protected $plugin = null;

    /**
     * Laravel view
     * @var string Laravel path 
     */
    protected $view = 'admin.' . __CLASS__;

    public function __construct(\App\Admin\Plugin $plugin) {
        $this->plugin = $plugin;
        $this->data['plugin'] = $plugin;

        $this->input = \Request::instance();
    }
    
    public function ajax() {
        $out = $this->onAJAX($this->input);
        
        echo json_encode($out);
        
        wp_die();
    }

    /**
     * Entry point of the page controller
     * By default, it fires onGet or onPost, based on Query method, and outputs their return value
     */
    public function run() {
        $this->errors = new \Illuminate\Support\MessageBag();
        $this->data['errors'] = $this->errors;
        $out = '';
        if (\Request::isMethod('POST')) {
            $out = $this->onPost($this->input);
        } elseif (\Request::isMethod('GET')) {
            $out = $this->onGet($this->input);
        }

        if (is_string($out)) {
            echo $out;
        } else if (is_object($out)) {
            if ($out instanceof \Illuminate\View\View) {
                echo $out->render();
            } else {
                echo $out;
            }
        }
    }

    /**
     * Laravel-like action fired on AJAX requests
     * @return mixed
     */
    protected function onAJAX(\Controllers\Request $input) {
        $this->data['input'] = $input;
        return "";
    }

    /**
     * Laravel-like action fired on GET requests
     * @return \Illuminate\View\View
     */
    protected function onGet(\Controllers\Request $input) {
        $this->data['input'] = $input;
        return view($this->view, $this->data);
    }

    /**
     * Laravel-like action fired on POST requests
     * @return \Illuminate\View\View
     */
    protected function onPost(\Controllers\Request $input) {
        return $this->onGet($input);
    }

    public function redirect($target) {
        return '<script>window.location = "' . $target . '"</script>';
    }

}
