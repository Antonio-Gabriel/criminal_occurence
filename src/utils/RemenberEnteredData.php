<?php

namespace CriminalOccurence\utils;

trait RemenberEnteredData
{
    public static function register(array $requestData): array
    {
        $formData = [];
        foreach ($requestData as $key => $value) {
            $_SESSION["formData"][$key]['value'] = $value;

            $formData = array_merge($formData, [$key => $value]);
        }

        return $formData;
    }

    public static function registerAnError(array $validateError, array $requestData)
    {
        foreach ($validateError as $requestKey => $value) {

            $_SESSION["formData"][$requestKey]["error"] = $value;

            foreach ($requestData as $key => $_) {
                if ($key !== $requestKey) {
                    $_SESSION["formData"][$key]["error"] = null;
                }
            }
        }
    }
}
