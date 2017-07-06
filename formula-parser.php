<?php
class FormulaParser {
    public function __construct($formula, $exceptionCase = []){
        $this->formula = $formula;
        $this->exceptionCase = $exceptionCase;
    }

    /**
     * Extract all variables in formula
     * To camelCase it match with outside variable name hold data
     * 
     * Example:
     * $f = "TOTAL - DISCOUNT";
     * 
     * extract out to return
     * ["TOTAL","DISCOUNT"]
     * @return array
     */
    public function variables() {
        $tokens = $this->tokenize();

        $variables = [];

        $operator = ["+","-","*","/","(",")"];

        foreach ($tokens as $token) {
            if(!in_array($token, $operator)){
                $variables[] = $token;
            }
        }
        return $variables;
    }

    /**
     * Tranform snake to camel case
     * Allow some exception
     * 
     * Example
     * TOTAL_VOID
     *  > totalVoid
     * 
     * TOTAL_GST, with exception on GST
     *  > totalGST
     * 
     * @param $value
     * @return string
     */
    public function camelCase($value){
        $words = explode("_", $value);
        $t_words = [];
        foreach ($words as $word) {
            $t_words[] = $this->lowerCase($word);
        }
        $lc_value = implode(" ", $t_words);
        $up_value = ucwords($lc_value);
        $no_space = str_replace(' ', '', $up_value);
        
        return lcfirst($no_space);
    }

    private function tokenize() {
        $parts = preg_split('(([0-9]*\.?[0-9]+|\+|-|\(|\)|\*|\/)|\s+)', $this->formula, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        $parts = array_map('trim', $parts);
        return $parts;
    }
    

    private function lowerCase($value){
        $lcValue = $value;

        if(!in_array($value, $this->exceptionCase)){
            $lcValue = strtolower($value);
        }

        return $lcValue;
    }
}
