<?php

// namespace blinkmobile\forms\utils\errors;
require_once realpath(dirname(__FILE__) . '/../../../../../vendor') . '/autoload.php';

use \blinkmobile\forms\utils\errors\Validation;


class ValidationTest extends \PHPUnit_Framework_TestCase
{
    private $validator;

    protected function setUp()
    {
      $list = array (
          'Rank' => ' is rank req',
          'Num' => ' is num req',
          'Details[0]/Age' => ' is age req0',
          'Details[0]/option' => ' is option req0',
          'Details[1]/Age' => 'Age/ is age req1',
          'Details[1]/option' => 'option/ is option req1',
          'Details[2]/Age' => 'Details[2]/Age// is age req2',
          'Details[2]/option' => 'Details[2]/option/ is option req2',
          'Details[3]/Age' => 'DetailsLabelPlus[3]/Age// is age req3',
          'Details[3]/option' => 'DetailsLabelMinus[3]/option/ is option req3',
          'Details[4]/Age' => 'DetailsLabelPlus[4]/Age// is age /req4',
          'Details[4]/option' => 'DetailsLabelMinus[4]/option/ is option req4',
          'Details[5]/Age' => '/ is age req5',
          'Details[5]/option' => '/ is option req5',
          'Details[6]/Age' => 'Age/ is age /req6',
          'Details[6]/subform[1]/name' => 'name/ is option /req61',
          'Details[6]/subform[2]/name' => 'name/ is option /req62',
          'Details[6]/option' => 'option/ is option /req6'
        );
      $this->validator = $this->getValidation($list);
    }

    public function testPossibleMessageFormats()
    {
      $list = array (
          'Rank' => ' is rank req',
          'Num' => ' is num req',
          'Details[0]/Age' => ' is age req0',
          'Details[0]/option' => ' is option req0',
          'Details[1]/Age' => 'Age/ is age req1',
          'Details[1]/option' => 'option/ is option req1',
          'Details[2]/Age' => 'Details[2]/Age// is age req2',
          'Details[2]/option' => 'Details[2]/option/ is option req2',
          'Details[3]/Age' => 'DetailsLabelPlus[3]/Age// is age req3',
          'Details[3]/option' => 'DetailsLabelMinus[3]/option/ is option req3',
          'Details[4]/Age' => 'DetailsLabelPlus[4]/Age// is age /req4',
          'Details[4]/option' => 'DetailsLabelMinus[4]/option/ is option req4',
          'Details[5]/Age' => '/ is age req5',
          'Details[5]/option' => '/ is option req5',
          'Details[6]/Age' => 'Age/ is age /req6',
          'Details[6]/option' => 'option/ is option /req6'
        );
        $message = array (
          ' is rank req',
          ' is num req',
          ' is age req0',
          ' is option req0',
          ' is age req1',
          ' is option req1',
          ' is age req2',
          ' is option req2',
          ' is age req3',
          ' is option req3',
          ' is age /req4',
          ' is option req4',
          ' is age req5',
          ' is option req5',
          ' is age /req6',
          ' is option /req6',
        );
        $index = 0;

        foreach ($list as $field => $msg) {
            $expectedMessage = $this->validator->getMessage ($field, $msg);
            $this->assertEquals($message[$index], $expectedMessage);
            $index++;
        }
    }

    public function testConversionFromOldToNew ()
    {
        $list = array (
          'Rank' => ' is rank req',
          'Num' => ' is num req',
          'Details' => array(
            0 => array(
              'Age' => ' is age req0',
              'option' => ' is option req0'
            ),
            1 => array(
              'Age' => ' is age req1',
              'option' => ' is option req1'
            ),
            2 => array(
              'Age' => ' is age req2',
              'option' => ' is option req2'
            ),
            3 => array(
              'Age' => ' is age req3',
              'option' => ' is option req3'
            ),
            4 => array(
              'Age' => ' is age /req4',
              'option' => ' is option req4'
            ),
            5 => array(
              'Age' => ' is age req5',
              'option' => ' is option req5'
            ),
            6 => array(
              'Age' => ' is age /req6',
              'subform' => array(
                1 => array(
                  'name' => ' is option /req61'
                ),
                2 => array(
                  'name' => ' is option /req62'
                )
              ),
              'option' => ' is option /req6'
            )
          )
        );

      $this->assertEquals($list, $this->validator->getErrors());
    }

    public function testErrorsWithNewFormat()
    {
        $list = array (
          'Rank' => ' is rank req',
          'Num' => ' is num req',
          'Details' => array(
            0 => array(
              'Age' => ' is age req0',
              'option' => ' is option req0'
            ),
            1 => array(
              'Age' => ' is age req1',
              'option' => ' is option req1'
            ),
            2 => array(
              'Age' => ' is age req2',
              'option' => ' is option req2'
            ),
            3 => array(
              'Age' => ' is age req3',
              'option' => ' is option req3'
            ),
            4 => array(
              'Age' => ' is age /req4',
              'option' => ' is option req4'
            ),
            5 => array(
              'Age' => ' is age req5',
              'option' => ' is option req5'
            ),
            6 => array(
              'Age' => ' is age /req6',
              'subform' => array(
                1 => array(
                  'name' => ' is option /req61'
                ),
                2 => array(
                  'name' => ' is option /req62'
                )
              ),
              'option' => ' is option /req'
            )
          )
        );
      $newValidator = $this->getValidation($list);
      $this->assertEquals($list, $newValidator->getErrors());
    }

    private function getValidation($list)
    {
      return new Validation($list);
    }
}
