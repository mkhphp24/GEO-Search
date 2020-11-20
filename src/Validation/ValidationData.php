<?php

namespace App\Validation;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class ValidationData
{

        const FLOAT_REGEX='/[0-9]*\.?[0-9]*/';
        private $requestData;
        private $validateManager;

        public function __construct(array $requestData)
        {
            $this->requestData = $requestData;
            $this->validateManager = Validation::createValidator();
        }

        /**
         * @param $constraint
         * @param $groups
         *
         * @return array[]
         */
        protected function setValidate($constraint, $groups)
        {
            $messageError = [];
            $values = [];
            $violations = $this->validateManager->validate($this->requestData, $constraint, $groups);

            foreach ($violations as $violation) {
                $messageError[] = array('nameProperty' => $violation->getPropertyPath(), 'message' => $violation->getMessage(), 'value' => $violation->getInvalidValue());
            }

            return ['Error' => $messageError, 'values' => $values];
        }

        /**
         * @return array
         */
        public function checkCordinate(): array
        {

            $groups     = new Assert\GroupSequence(['Default', 'custom']);
            $constraint = new Assert\Collection([
                   'form-distance-lat' => [ new Assert\NotBlank(), new Assert\Regex(['pattern' => self::FLOAT_REGEX]) ]
                ,  'form-distance-lng' => [ new Assert\NotBlank(), new Assert\Regex(['pattern' => self::FLOAT_REGEX]) ]
                ,  'form-distance-km' => [ new Assert\NotBlank(),new Assert\Type(['type'=>['digit']]) ]
            ]);

            return $this->setValidate($constraint, $groups);

        }

        /**
         * @return array
         */
        public function checkPostCode(): array
        {

            $groups     = new Assert\GroupSequence(['Default', 'custom']);
            $constraint = new Assert\Collection([
                'post-code' => [ new Assert\NotBlank(),new Assert\Type(['type'=>['digit']]) ]
            ]);

            return $this->setValidate($constraint, $groups);

        }


}
