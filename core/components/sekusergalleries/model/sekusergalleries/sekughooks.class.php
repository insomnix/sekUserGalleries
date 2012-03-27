<?php
 /**
 * User Galleries
 *
 * Copyright 2012 by Stephen Smith <ssmith@seknetsolutions.com>
 *
 * sekUserGalleries is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * sekUserGalleries is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * sekUserGalleries; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package sekusergalleries
 */

class sekugHooks {
    /**
     * @var array $errors A collection of all the processed errors so far.
     * @access public
     */
    public $errors = array();
    /**
     * @var array $hooks A collection of all the processed hooks so far.
     * @access public
     */
    public $hooks = array();
    /**
     * @var modX $modx A reference to the modX instance.
     * @access public
     */
    public $modx = null;
    /**
     * @var sekUserGalleries $ug A reference to the sekUserGalleries instance.
     * @access public
     */
    public $ug = null;
    /**
     * @var string If a hook redirects, it needs to set this var to use proper
     * order of execution on redirects/stores
     * @access public
     */
    public $redirectUrl = null;
    /**
     * @var array
     */
    public $fields = array();
    public $controller;

    /**
     * The constructor for the usergalleryHooks class
     *
     * @param sekUserGalleries $ug A reference to the sekugUserGalleries class instance.
     * @param sekUserGalleriesController &$controller A reference to the current controller.
     * @param array $config Optional. An array of configuration parameters.
     */
    function __construct(sekUserGalleries &$ug,sekugController &$controller,array $config = array()) {
        $this->ug =& $ug;
        $this->modx =& $ug->modx;
        $this->config = array_merge(array(
        ),$config);
    }

    /**
     * Loads an array of hooks. If one fails, will not proceed.
     *
     * @access public
     * @param array $hooks The hooks to run.
     * @param array $fields The fields and values of the form
     * @param array $customProperties Any other custom properties to load into a custom hook
     * @return array An array of field name => value pairs.
     */
    public function loadMultiple($hooks,array $fields = array(),array $customProperties = array()) {
        if (empty($hooks)) return array();
        if (is_string($hooks)) $hooks = explode(',',$hooks);

        $this->hooks = array();
        $this->fields =& $fields;
        foreach ($hooks as $hook) {
            $hook = trim($hook);
            $success = $this->load($hook,$this->fields,$customProperties);
            if (!$success) return $this->hooks;
            /* dont proceed if hook fails */
        }
        return $this->hooks;
    }

    /**
     * Load a hook. Stores any errors for the hook to $this->errors.
     *
     * @access public
     * @param string $hook The name of the hook. May be a Snippet name.
     * @param array $fields The fields and values of the form.
     * @param array $customProperties Any other custom properties to load into a custom hook.
     * @return boolean True if hook was successful.
     */
    public function load($hook,array $fields = array(),array $customProperties = array()) {
        $success = false;
        if (!empty($fields)) $this->fields =& $fields;
        $this->hooks[] = $hook;

        $reserved = array('load','_process','__construct','getErrorMessage','addError','getValue','getValues','setValue','setValues');
        if (method_exists($this,$hook) && !in_array($hook,$reserved)) {
            /* built-in hooks */
            $success = $this->$hook($this->fields);

        } else if ($snippet = $this->modx->getObject('modSnippet',array('name' => $hook))) {
            /* custom snippet hook */
            $properties = array_merge($this->ug->config,$customProperties);
            $properties['ug'] =& $this->ug;
            $properties['hook'] =& $this;
            $properties['fields'] = $this->fields;
            $properties['errors'] =& $this->errors;
            $success = $snippet->process($properties);

        } else {
            /* no hook found */
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries] Could not find hook "'.$hook.'".');
            $success = true;
        }

        if (is_array($success) && !empty($success)) {
            $this->errors = array_merge($this->errors,$success);
            $success = false;
        } else if ($success != true) {
            $this->errors[$hook] .= ' '.$success;
            $success = false;
        }
        return $success;
    }
	
    /**
     * Attempt to load a file-based hook given a name
     * @param string $path The absolute path of the hook file
     * @param array $customProperties An array of custom properties to run with the hook
     * @return boolean True if the hook succeeded
     */
    private function _loadFileBasedHook($path,array $customProperties = array()) {
        $scriptProperties = array_merge($this->login->config,$customProperties);
        $formit =& $this->login;
        $hook =& $this;
        $fields = $this->fields;
        $errors =& $this->errors;
        try {
            $success = include $path;
        } catch (Exception $e) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[Login] '.$e->getMessage());
        }
        return $success;
    }

    /**
     * Gets the error messages compiled into a single string.
     *
     * @access public
     * @param string $delim The delimiter between each message.
     * @return string The concatenated error message
     */
    public function getErrorMessage($delim = "\n") {
        return implode($delim,$this->errors);
    }

    /**
     * Adds an error to the stack.
     *
     * @access private
     * @param string $key The field to add the error to.
     * @param string $value The error message.
     * @return string The added error message with the error wrapper.
     */
    public function addError($key,$value) {
        $this->errors[$key] .= $value;
        return $this->errors[$key];
    }

    /**
     * See if there are any errors in the stack.
     *
     * @return boolean
     */
    public function hasErrors() {
        return !empty($this->errors);
    }

    /**
     * Get all errors for this current request
     *
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Sets the value of a field.
     *
     * @param string $key The field name to set.
     * @param mixed $value The value to set to the field.
     * @return mixed The set value.
     */
    public function setValue($key,$value) {
        $this->fields[$key] = $value;
        return $this->fields[$key];
    }

    /**
     * Sets an associative array of field name and values.
     *
     * @param array $values A key/name pair of fields and values to set.
     */
    public function setValues(array $values = array()) {
        foreach ($values as $key => $value) {
            $this->setValue($key,$value);
        }
    }

    /**
     * Gets the value of a field.
     *
     * @param string $key The field name to get.
     * @return mixed The value of the key, or null if non-existent.
     */
    public function getValue($key) {
        if (array_key_exists($key,$this->fields)) {
            return $this->fields[$key];
        }
        return null;
    }

    /**
     * Gets an associative array of field name and values.
     *
     * @return array $values A key/name pair of fields and values.
     */
    public function getValues() {
        return $this->fields;
    }

    /**
     * @return array
     */
    public function getFields() {
        return $this->fields;
    }
    
    /**
     * Redirect to a specified URL.
     *
     * Properties needed:
     * - redirectTo - the ID of the Resource to redirect to.
     *
     * @param array $fields An array of cleaned POST fields
     * @return boolean False if unsuccessful.
     */
    public function redirect(array $fields = array()) {
        if (empty($this->login->config['redirectTo'])) return false;

        $url = $this->modx->makeUrl($this->login->config['redirectTo'],'','','abs');
        return $this->modx->sendRedirect($url);
    }
	
    /**
     * Processes string and sets placeholders
     *
     * @param string $str The string to process
     * @param array $placeholders An array of placeholders to replace with values
     * @return string The parsed string
     */
    public function _process($str,array $placeholders = array()) {
        foreach ($placeholders as $k => $v) {
            $str = str_replace('[[+'.$k.']]',$v,$str);
        }
        return $str;
    }

    /**
     * Ensure the a field passes a spam filter.
     *
     * Properties:
     * - spamEmailFields - The email fields to check. A comma-delimited list.
     *
     * @access public
     * @param array $fields An array of cleaned POST fields
     * @return boolean True if email was successfully sent.
     */
    public function spam(array $fields = array()) {
        $passed = true;
        $spamEmailFields = $this->modx->getOption('spamEmailFields',$this->login->config,'email');
        $emails = explode(',',$spamEmailFields);
        if ($this->modx->loadClass('stopforumspam.StopForumSpam',$this->login->config['modelPath'],true,true)) {
            $sfspam = new StopForumSpam($this->modx);
            foreach ($emails as $email) {
                $spamResult = $sfspam->check($_SERVER['REMOTE_ADDR'],$fields[$email]);
                if (!empty($spamResult)) {
                    $spamFields = implode($this->modx->lexicon('register.spam_marked')."\n<br />",$spamResult);
                    $this->errors[$email] = $this->modx->lexicon('register.spam_blocked',array(
                        'fields' => $spamFields,
                    ));
                    $passed = false;
                }
            }
        } else {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[Register] Couldnt load StopForumSpam class.');
        }
        return $passed;
    }

}