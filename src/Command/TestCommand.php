<?php

namespace App\Command;

use App\DTO\SerializerTestDTO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;

class TestCommand extends Command
{
    protected static $defaultName = 'app:test';

    private $serializer;

    /**
     * @var string
     */
    private $badFormattedJSON = <<<EOF
{
    "unique-id": "123",
    "float": "123.12",
    "key": "value",
    "nonExistent": "infinity"
}
EOF;

    /**
     * TestCommand constructor.
     * @param $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        dump($this->badFormattedJSON);
        $dto = $this->serializer->deserialize($this->badFormattedJSON, SerializerTestDTO::class, 'json');
        dump($dto);
    }
}
