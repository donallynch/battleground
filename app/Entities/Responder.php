<?php

namespace App\Entities;

/**
 * Class Responder
 * @package App
 */
class Responder
{
    /** @var int $status */
    private $status = 200;

    /** @var string $code */
    private $code = '';

    /** @var array $errors */
    private $errors = [];

    /** @var array $payload */
    private $payload = [];

    /**
     * @param int $status
     * @param string $code
     * @param array $errors
     * @param array $payload
     * @return $this
     */
    public function set($status = 200, $code = '', $errors = [], $payload = [])
    {
        $this->status = $status;
        $this->code = $code;
        $this->errors = $errors;
        $this->payload = $payload;

        return $this;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        $output = [
            'status' => $this->status,
            'code' => $this->code
        ];

        /* If there are errors */
        if (count($this->errors) > 0) {
            $output['errors'] = $this->errors;
        }

        /* If there's a payload */
        if (count($this->payload) > 0) {
            $output['payload'] = $this->payload;
        }

        return $output;
    }

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus($status = 200)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setCode($code = 'ok')
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @param array $errors
     * @return $this
     */
    public function setErrors($errors = [])
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * @param array $payload
     * @return $this
     */
    public function setPayload($payload = [])
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return $this->payload;
    }
}

