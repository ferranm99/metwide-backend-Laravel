<?php

namespace App\Services\AAPTFrontier\Actions;

use App\Models\AaptTestOutcome;

class GenerateAaptTestOutcome
{
    public static function execute($accessQualID, $testOutcome)
    {

        $aaptTestOutcome = new AaptTestOutcome();

        $aaptTestOutcome->access_qual_id = $accessQualID;

        $aaptTestOutcome->test_number = $testOutcome->testNumber ?? null;
        $aaptTestOutcome->test_description = $testOutcome->testDescription ?? null;
        $aaptTestOutcome->test_response = $testOutcome->testResponse ?? null;
        $aaptTestOutcome->test_result = $testOutcome->testResult ?? null;

        $aaptTestOutcome->save();

        return $aaptTestOutcome;
    }
}
