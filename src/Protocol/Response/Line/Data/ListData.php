<?php

namespace Gricob\IMAP\Protocol\Response\Line\Data;

use Gricob\IMAP\Protocol\Response\Line\Line;

class ListData implements Line
{
    private const PATTERN = '/^\* LIST \((?<nameAttributes>.*?)\) \"(?<hierarchyDelimiter>.*?)\" \"(?<name>.*?)\"/';

    public function __construct(
        public array $nameAttributes,
        public string $hierarchyDelimiter,
        public string $name
    ) {
    }

    public static function tryParse(string $raw): ?static
    {
        if (!preg_match(self::PATTERN, $raw, $matches)) {
            return null;
        }

        return new self(
            empty($matches['nameAttributes']) ? [] : explode(' ', $matches['nameAttributes']),
            $matches['hierarchyDelimiter'],
            $matches['name']
        );
    }
}