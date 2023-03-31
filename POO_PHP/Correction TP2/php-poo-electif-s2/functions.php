<?php

function chance($percentage): bool
{
    return rand() % 100 < $percentage;
}
