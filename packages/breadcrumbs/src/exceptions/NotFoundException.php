<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 30.05.2017
 * Time: 22:15
 */

namespace MyLibrary\Breadcrumbs\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotFoundException extends NotFoundHttpException
{
    /**
     * Constructor.
     *
     * @param string     $message  The internal exception message
     * @param \Exception $previous The previous exception
     * @param int        $code     The internal exception code
     */
    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        parent::__construct($message, $previous, $code);
    }
}