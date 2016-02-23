<?php

namespace PortalBundle\Service;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * Log system service
 * @DI\Service("portal.service.error", public=true)
 */
class ErrorService
{
    /**
     * @var bool
     */
    public $scopeError;

    /**
     * @var array
     */
    public $errors;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->errors = [];
        $this->scopeError = false;
    }

    /**
     * resetScopeError
     */
    public function resetScopeError()
    {
        $this->scopeError = false;
    }

    /**
     * getScopeError
     */
    public function getScopeError()
    {
        return $this->scopeError;
    }

    /**
     * @param $codeError
     * @param $levelError
     * @param $message
     */
    public function addError($codeError, $levelError, $message)
    {
        $this->scopeError = true;
        $keyError = sha1($message);
        $keyExist = false;

        foreach ($this->errors as $error) {
            if (isset($error['message']) && sha1($error['message']) === $keyError) {
                $keyExist = true;
            }
        }

        if (!$keyExist) {
            $this->errors[] = ['code' => $codeError, 'level' => $levelError, 'message' => $message];
        }
        
//        dump($this->errors);
    }

    /**
     * @param $message
     * @return string
     */
    protected function format($message)
    {
        return htmlentities($message);
    }

    /**
     * @return array
     */
    public function getHasError()
    {
        if (count($this->errors) > 0) {
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function getTotalError()
    {
        return count($this->errors);
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        $totalError = count($this->errors);

        if ($totalError > 0) {
            
            foreach($this->errors as &$error) {
                $error['message'] = $this->format($error['message']);
             }
            
            return ['hasError' => true, 'errors' => $this->errors];
        }

        return ['hasError' => false];
    }
}
