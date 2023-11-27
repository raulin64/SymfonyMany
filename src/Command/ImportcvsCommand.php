<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
class  ImportcvsCommand extends Command
{
	
	    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:print-cvs')
            // the short description shown while running "php bin/console list"
            ->setHelp("This command allows you to print some text in the console")
            // the full command description shown when running the command with
            ->setDescription('Prints some text into the console with given parameters.')
            
        ;
    }
    // change these options about the file to read
    private $csvParsingOptions = array(
        'finder_in' => 'src/Resources',
        'finder_name' => 'movies.csv',
        'ignoreFirstLine' => true
    );

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // use the parseCSV() function
        $csv = $this->parseCSV();
		print_r( $csv) ;
		return is_int($output) ? $output : 0;
    }

    /**
     * Parse a csv file
     * 
     * @return array
     */
    private function parseCSV()
    {
        $ignoreFirstLine = $this->csvParsingOptions['ignoreFirstLine'];

        $finder = new Finder();
        $finder->files()
            ->in($this->csvParsingOptions['finder_in'])
            ->name($this->csvParsingOptions['finder_name'])
        ;
        foreach ($finder as $file) { $csv = $file; }

        $rows = array();
        if (($handle = fopen($csv->getRealPath(), "r")) !== FALSE) {
            $i = 0;
            while (($data = fgetcsv($handle, null, ";")) !== FALSE) {
                $i++;
                if ($ignoreFirstLine && $i == 1) { continue; }
                $rows[] = $data;
            }
            fclose($handle);
        }

        return $rows;
    }
}