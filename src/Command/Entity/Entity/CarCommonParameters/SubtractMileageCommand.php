<?php
declare(strict_types=1);

namespace App\Command\Entity\Entity\CarCommonParameters;

use App\Handler\Command\Entity\Entity\CarCommonParameters\SubtractMileageCommand\Handler as SubtractMileageCommandHandler;
use App\Util\Common\TypeConvertingResolver;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class SubtractMileageCommand extends Command
{
    use LockableTrait;

    protected static $defaultName = "app:subtract-mileage";

    private SubtractMileageCommandHandler $subtractMileageCommandHandler;

    public function __construct(
        SubtractMileageCommandHandler $subtractMileageCommandHandler, string $name = null
    )
    {
        $this->subtractMileageCommandHandler = $subtractMileageCommandHandler;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription(
                'Subtracts the percent from mileage-parameter for mileage-parameter values that are larger than the "mileageMaxBar" command parameter'
            )
            ->addOption(
                'percent',
                null,
                InputOption::VALUE_OPTIONAL,
                'The percent of mileage-parameter value',
                30
            )
            ->addOption(
                'mileageMaxBar',
                null,
                InputOption::VALUE_OPTIONAL,
                'The mileage-parameter value after which the subtraction is performing',
                150000
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            if ($this->lock(null, true)) {
                $this->checkOptions($input);

                $this->subtractMileageCommandHandler->subtractMileage(
                    (int)$input->getOption('percent'),
                    (int)$input->getOption('mileageMaxBar')
                );
            } else {
                $output->writeln('The command is already running in another process.');

                return 1;
            }
        } catch (InvalidArgumentException $exception) {
            $output->writeln($exception->getMessage());
        } catch (\Throwable $throwable) {
            $output->writeln($throwable->getMessage());
            $output->writeln($throwable->getTraceAsString());
        }

        $this->release();

        return 0;
    }

    private function checkOptions(InputInterface $input): void
    {
        $typeConvertingResolver = new TypeConvertingResolver();

        $exception = new InvalidArgumentException('Bad inputs');

        if (!$typeConvertingResolver->canConvertToInteger($percent = (string)$input->getOption('percent'))
            || (((int)$percent <= 0) || (int)$percent >= 100)) {
            throw $exception;
        }

        if ((!$typeConvertingResolver->canConvertToInteger($mileageMaxBar = (string)$input->getOption('mileageMaxBar'))
            || (int)$mileageMaxBar < 0)) {
            throw $exception;
        }
    }
}