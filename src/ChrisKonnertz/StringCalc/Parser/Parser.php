<?php

namespace ChrisKonnertz\StringCalc\Parser;

use ChrisKonnertz\StringCalc\Exceptions\NotFoundException;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Number;
use ChrisKonnertz\StringCalc\Symbols\SymbolContainer;
use ChrisKonnertz\StringCalc\Symbols\SymbolContainerInterface;
use ChrisKonnertz\StringCalc\Tokenizer\Token;

/**
 * The parsers has one important method: parse()
 * It takes an array of tokens as input and
 * returns an array of nodes as output.
 * These nodes are the syntax tree of the term.
 *
 * @package ChrisKonnertz\StringCalc\Parser
 */
class Parser
{

    /**
     * The symbol container with all possible symbols
     *
     * @var SymbolContainerInterface
     */
    protected $symbolContainer;

    /**
     * Parser constructor.
     *
     * @param SymbolContainerInterface $symbolContainer
     */
    public function __construct(SymbolContainerInterface $symbolContainer)
    {
        $this->symbolContainer = $symbolContainer;
    }

    /**
     * Parses an array with tokens. Returns an array of nodes.
     * These nodes define a syntax tree.
     *
     * @param Token[] $tokens
     * @return array
     */
    public function parse(array $tokens)
    {
        $nodes = $this->detectSymbols($tokens);

        $nodes = $this->createTree($nodes);

        // TODO implement missing stuff

        return $nodes;
    }

    /**
     * Creates nodes from tokens. Nodes belong to a particular symbol.
     *
     * @param Token[] $tokens
     * @return Node[]
     * @throws \Exception
     */
    protected function detectSymbols(array $tokens)
    {
        $nodes = [];

        foreach ($tokens as $token) {
            $type = $token->getType();

            if ($type == Token::TYPE_WORD) {
                $identifier = $token->getValue();
                $symbol = $this->symbolContainer->find($identifier);

                if ($symbol === null) {
                    throw new NotFoundException('Error: Detected unknown or invalid identifier.');
                }
            } elseif ($type == Token::TYPE_NUMBER) {
                $symbol = $this->symbolContainer->findSubtype(Number::class)[0];
            } else { // Type Token::TYPE_CHARACTER:
                $identifier = $token->getValue();
                $symbol = $this->symbolContainer->find($identifier);

                if ($symbol === null) {
                    throw new NotFoundException('Error: Detected unknown or invalid identifier.');
                }
            }

            $node = new Node($token, $symbol);

            $nodes[] = $node;
        }

        return $nodes;
    }

    /**
     * @param Node[] $nodes
     * @return Node[]
     */
    protected function createTree(array $nodes)
    {
        $nodes = $this->parseBrackets($nodes);

        // TODO implement missing stuff

        return $nodes;
    }

    /**
     * @param Node[] $nodes
     * @return array
     */
    protected function parseBrackets(array $nodes)
    {
        // TODO implement missing stuff

        return $nodes;
    }

}