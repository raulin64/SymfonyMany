<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\Pelicula;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Validator\Constraints\DateTime;

class CsvImportCommand extends Command
{

    public function __construct(EntityManagerInterface $em){

        parent::__construct();

        $this->em = $em;
    }

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:import-developpers';

    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Import a new movie.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to import a movie...')
    ;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Importation en cours');


        $reader = Reader::createFromPath('%kernel.root_dir%/../src/Resources/movies.csv')
            ->setHeaderOffset(0)
        ;
        $results = $reader->getrecords();
        $io->progressStart(iterator_count($results));

        //Disable SQL Logging: to avoid huge memory loss.
        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);

		$date_published = new \DateTime();
		
        foreach ($results as $row) {
			
			$input = $row['date_published']; 

				$time_input = strtotime($input); 
					
																												$anio = date("Y", $time_input);
																												$mes = date("m", $time_input);
																												$dia = date("d", $time_input);
			

			$date_published->setDate($anio,$mes,$dia); 
			
			//print_r($date_published);

            $Pelicula = $this->em->getRepository(Pelicula::class)
            ->findOneBy([
				  'imdb_title_id' => ($row['imdb_title_id']),
				  'title' => ($row['title']),
				  'original_title' => ($row['original_title']), 
				  'year' => ($row['year']), 
				  'date_published' => ($date_published), 
				  'genre' => ($row['genre']), 
				  'duration' => ($row['duration']),
				  'country' => ($row['country']),
				  'language' => ($row['language']),
				  'director' => ($row['director']), 
				  'writer' => ($row['writer']), 
				  'production_company' => ($row['production_company']), 
				  'actors' => ($row['actors']), 
				  'description' => ($row['description']),
				  'avg_vote' => ($row['avg_vote']),
				  'votes' => ($row['votes']),
				  'budget' => ($row['budget']),
				  'usa_gross_income' => ($row['usa_gross_income']),
				  'worlwide_gross_income' => ($row['worlwide_gross_income']),
				  'metascore' => ($row['metascore']), 
				  'reviews_from_users' => ($row['reviews_from_users']),
				  'reviews_from_critics' => ($row['reviews_from_critics'])
            ])
            ;

            if (null === $Pelicula) {
                $Pelicula = new Pelicula;
			
                $Pelicula
				  ->setimdb_title_id($row['imdb_title_id'])
				  ->settitle($row['title'])
				  ->setoriginal_title($row['original_title']) 
				  ->setyear($row['year']) 
				  ->setdate_published($date_published) 
				  ->setgenre($row['genre']) 
				  ->setduration($row['duration'])
				  ->setcountry($row['country'])
				  ->setlanguage($row['language'])
				  ->setdirector($row['director']) 
				  ->setwriter($row['writer']) 
				  ->setproduction_company($row['production_company']) 
				  ->setactors($row['actors']) 
				  ->setdescription($row['description'])
				  ->setavg_vote($row['avg_vote'])
				  ->setvotes($row['votes'])
				  ->setbudget($row['budget'])
				  ->setusa_gross_income($row['usa_gross_income'])
				  ->setworlwide_gross_income($row['worlwide_gross_income'])
				  ->setmetascore($row['metascore']) 
				  ->setreviews_from_users($row['reviews_from_users'])
				  ->setreviews_from_critics($row['reviews_from_critics']);

                $this->em->persist($Pelicula);
                $this->em->flush();
                $this->em->clear();             
            }
      

            $io->progressAdvance();
        }

        $this->em->flush();
        $this->em->clear();

        $io->progressFinish();
        $io->success('Importation terminée avec succès');
		return is_int($output) ? $output : 0;
    }
}