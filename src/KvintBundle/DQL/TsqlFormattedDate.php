<?php

namespace KvintBundle\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class TsqlFormattedDate extends FunctionNode
{
    public $dateString = '1990-01-01';
    public $format = 104;

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->dateString = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->format  = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
    public function getSql(SqlWalker $sqlWalker)
    {
        return 'convert(varchar,' .
            $this->dateString->dispatch($sqlWalker) . ', ' .
            $this->format->dispatch($sqlWalker) .
            ')';
    }
}