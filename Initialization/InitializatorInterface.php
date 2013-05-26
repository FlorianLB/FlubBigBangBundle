<?php

namespace Flub\BigBangBundle\Initialization;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

interface InitializatorInterface
{
    public function execute();
}