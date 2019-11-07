<?php

namespace Zeiss\Command;

use Exception;
use Psr\Log\LoggerInterface;
use Recruiter\Geezer\Command\RobustCommand;
use Recruiter\Geezer\Command\RobustCommandRunner;
use Recruiter\Geezer\Leadership\Anarchy;
use Recruiter\Geezer\Leadership\LeadershipStrategy;
use Recruiter\Geezer\Timing\ConstantPause;
use Recruiter\Geezer\Timing\WaitStrategy;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Zeiss\Projection\Projection;
use Zeiss\Projection\Registry;
use Zeiss\Projection\Runner;

class ProjectionRunner implements RobustCommand
{
    /**
     * @var Runner
     */
    private $runner;

    /**
     * @var LeadershipStrategy
     */
    private $leadershipStrategy;

    /**
     * @var WaitStrategy
     */
    private $waitStrategy;

    /**
     * @var string
     */
    private $projectionName;

    public function __construct(
        Runner $runner,
        LeadershipStrategy $leadershipStrategy,
        WaitStrategy $waitStrategy,
        string $projectionName
    ) {
        $this->runner = $runner;
        $this->leadershipStrategy = $leadershipStrategy;
        $this->waitStrategy = $waitStrategy;
        $this->projectionName = $projectionName;
    }

    public static function forProjection(
        Projection $projection,
        Registry $registry,
        LoggerInterface $logger
    ): RobustCommandRunner {
        return self::forProjectionWithStrategies(
            $projection,
            $registry,
            new Anarchy(),
            new ConstantPause(1000),
            $logger
        );
    }

    public static function forProjectionWithStrategies(
        Projection $projection,
        Registry $registry,
        LeadershipStrategy $leadershipStrategy,
        WaitStrategy $waitStrategy,
        LoggerInterface $logger
    ): RobustCommandRunner {
        return new RobustCommandRunner(
            new self(
                new Runner($projection, $registry),
                $leadershipStrategy,
                $waitStrategy,
                $projection::name()
            ),
            $logger
        );
    }

    public function leadershipStrategy(): LeadershipStrategy
    {
        return $this->leadershipStrategy;
    }

    public function waitStrategy(): WaitStrategy
    {
        return $this->waitStrategy;
    }

    public function name(): string
    {
        return sprintf(
            'run-projection:%s',
            $this->projectionName
        );
    }

    public function description(): string
    {
        return sprintf(
            'Project events for %s',
            $this->projectionName
        );
    }

    public function definition(): InputDefinition
    {
        return new InputDefinition();
    }

    public function init(InputInterface $input): void
    {
        $this->runner->initialize();
    }

    /**
     * @return bool true on success, false otherwhise (e.g. nothing to do)
     */
    public function execute(): bool
    {
        return $this->runner->execute();
    }

    /**
     * @return bool true on successful shutdown, false otherwhise
     */
    public function shutdown(?Exception $e = null): bool
    {
        return true;
    }
}
