<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
// Add the InputArgument class
use Symfony\Component\Console\Input\InputArgument;

class TestCommand extends Command
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:print-text')
            // the short description shown while running "php bin/console list"
            ->setHelp("This command allows you to print some text in the console")
            // the full command description shown when running the command with
            ->setDescription('Prints some text into the console with given parameters.')
            // Arguments
            ->addArgument('text', InputArgument::REQUIRED, 'The text to print')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'My Second Symfony command',// A line
            '============',// Another line
            '',// Empty line
        ]);
        
        // Get providen text using the $input->getArgument method.
        $text = $input->getArgument('text');
        
        $output->writeln("Providen text : ".$text);
		 return is_int($output) ? $output : 0;
    }
}