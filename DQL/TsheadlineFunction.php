<?php
namespace Oi\PostgresSearchBundle\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\TokenType;

/**
 * TsheadlineFunction ::= "TSHEADLINE" "(" StringPrimary "," StringPrimary ")"
 */
class TsheadlineFunction extends FunctionNode
{
    public $fieldName = null;
    public $queryString = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->fieldName = $parser->StringPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->queryString = $parser->StringPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker): string
    {
        return
            "ts_headline(" . $this->fieldName->dispatch($sqlWalker) . ", " .
            " plainto_tsquery(" . $this->queryString->dispatch($sqlWalker) . "),
            'StartSel = <mark>, StopSel = </mark>, HighlightAll=FALSE')";
    }
}
