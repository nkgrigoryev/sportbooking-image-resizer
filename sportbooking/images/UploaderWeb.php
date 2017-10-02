<?php

namespace sportbooking\images;
use Error;
use Exception;
use sportbooking\images\exceptions\InvalidInputDataException;
use sportbooking\images\exceptions\NoImagesException;


// TODO вынести _echoError и _echoResult в отдельный класс. Написать тесты на этот класс.
/**
 * Class UploaderWeb
 * @package sportbooking\images
 */
class UploaderWeb
{
    /**
     * Error code.
     */
    const NO_IMAGES_CODE = 'NO_IMAGES_ERROR';

    /**
     * Error code.
     */
    const INVALID_INPUT_DATA = 'INVALID_INPUT_DATA';

    /**
     * Error code.
     */
    const UNKNOWN_ERROR_CODE = 'UNKNOWN_ERROR';

    /**
     * Error code.
     */
    const UNKNOWN_ERROR_MESSAGE = 'Unknown error.';

    // TODO Add more errors
    /**
     * @var array
     */
    private static $_exceptions =
    [
        NoImagesException::class => self::NO_IMAGES_CODE,
        InvalidInputDataException::class => self::INVALID_INPUT_DATA
    ];

    // TODO config example
    /**
     * UploaderWeb constructor.
     * @param array $config
     */
    public function __construct
    (
        array $config
    )
    {
        // TODO move files getting to another class.
        $files = $_FILES['images'] ?? [];
        if (!is_array($files)) $this->_echoError('IMAGE_MUST_BE_ARRAY' , 'Parameter "images" must be array');
        try
        {
            $uploader = new Uploader($config, $files);
            $uploader->upload();
            $result = $uploader->getImagesDataInArray();
            $this->_echoResult($result);
        }
        catch (Exception $exception)
        {
            $code = self::UNKNOWN_ERROR_CODE;
            $message = self::UNKNOWN_ERROR_MESSAGE;
            $exceptionClass = get_class($exception);
            if (isset(self::$_exceptions[$exceptionClass]))
            {
                $code = self::$_exceptions[$exceptionClass];
                $message = $exception->getMessage();
            }
            $this->_echoError($code, $message);
        }
        catch (Error $error)
        {
            $this->_echoError(self::UNKNOWN_ERROR_CODE, self::UNKNOWN_ERROR_MESSAGE);
        }
    }

    // TODO dockblock

    /**
     * @param $code
     * @param $message
     */
    private function _echoError($code, $message)
    {
        $result =
        [
            'error' =>
            [
                'code' => $code,
                'message' => $message
            ]
        ];
        echo json_encode($result, JSON_PRETTY_PRINT) . PHP_EOL;
    }

    // TODO dockblock

    /**
     * @param $result
     */
    private function _echoResult($result)
    {
        $result =
        [
            'result' => $result,
        ];
        echo json_encode($result,  JSON_PRETTY_PRINT) . PHP_EOL;
    }
}
