<?php

namespace Schrosis\BladeSQL\BladeSQL\UseCase;

class LikeEscapeAction
{
    public function __invoke(string $keyword): string
    {
        return addcslashes($keyword, '%_\\');
    }
}
