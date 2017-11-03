<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ImportDataCommand extends ContainerAwareCommand
{
    protected function configure()
    {

        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:import_data')
            ->setDescription('Import data to database.')
            ->setHelp('This command allows you to import a required data to database')
            ->addArgument('filename', InputArgument::REQUIRED, 'The filename is: ');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln([
            'Import Data',
            '============',
            '',
        ]);

        $output->writeln('Whoa!');

        {
            $filename = $input->getArgument('filename');
            $workflowOrganizer = $this->getContainer()->get('workflow.organizer');
            $result = $workflowOrganizer->processCSVFile(new \SplFileObject($filename), $test = $input->getOption('test'));
            $output->writeln('Filename: ' . $input->getArgument('filename'));

            $output->write('Files were successful: ' .
                ($result['result']->getTotalProcessedCount() - count($result['failedItems'])));
            $output->write('Files were processed: ' . $result['result']->getTotalProcessedCount());
            $output->write('Files were failed: ' . count($result['failedItems']));
            $output->write('Files were skipped: ');
            foreach ($result['failedItems'] as $item) {
                $output->writeln($item['productCode']);
            }

            $output->writeln('File successfully imported!');

        }

    }
}