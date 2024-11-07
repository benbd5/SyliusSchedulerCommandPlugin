<?php

declare(strict_types=1);

namespace Synolia\SyliusSchedulerCommandPlugin\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Synolia\SyliusSchedulerCommandPlugin\Enum\ScheduledCommandStateEnum;
use Synolia\SyliusSchedulerCommandPlugin\Repository\ScheduledCommandRepository;

/**
 * @ORM\MappedSuperclass(repositoryClass="Synolia\SyliusSchedulerCommandPlugin\Repository\ScheduledCommandRepository")
 * @ORM\Table("synolia_scheduled_commands")
 */
#[ORM\MappedSuperclass(repositoryClass: ScheduledCommandRepository::class)]
#[ORM\Table(name: 'synolia_scheduled_commands')]
class ScheduledCommand implements ScheduledCommandInterface
{
    /**
     * @var int|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    protected $id;

    /** @ORM\Column(type="string") */
    #[ORM\Column(type: Types::STRING)]
    protected string $name = '';

    /** @ORM\Column(type="string") */
    #[ORM\Column(type: Types::STRING)]
    protected string $command = '';

    /** @ORM\Column(type="string", nullable=true) */
    #[ORM\Column(type: Types::STRING, nullable: true)]
    protected ?string $arguments = null;

    /** @ORM\Column(name="executed_at", type="datetime", nullable=true) */
    #[ORM\Column(name: 'executed_at', type: Types::DATETIME_MUTABLE, nullable: true)]
    protected ?\DateTime $executedAt = null;

    /** @ORM\Column(type="integer", nullable=true) */
    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    protected ?int $lastReturnCode = null;

    /**
     * Log's file name (without path)
     *
     * @ORM\Column(type="string", nullable=true)
     */
    #[ORM\Column(type: Types::STRING, nullable: true)]
    protected ?string $logFile = null;

    /** @ORM\Column(type="datetime", nullable=true) */
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    protected ?\DateTime $commandEndTime = null;

    /** @ORM\Column(name="created_at", type="datetime", nullable=false) */
    #[ORM\Column(name: 'created_at', type: Types::DATETIME_MUTABLE, nullable: false)]
    protected \DateTime $createdAt;

    /** @ORM\Column(name="state", type="string") */
    #[ORM\Column(name: 'state', type: Types::STRING)]
    protected string $state = ScheduledCommandStateEnum::WAITING;

    /** @ORM\Column(type="integer", nullable=true) */
    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    protected ?int $timeout = null;

    /** @ORM\Column(type="integer", nullable=true) */
    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    protected ?int $idleTimeout = null;

    /**
     * @ORM\ManyToOne(targetEntity="Synolia\SyliusSchedulerCommandPlugin\Entity\CommandInterface", inversedBy="scheduledCommands")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    #[ORM\ManyToOne(targetEntity: CommandInterface::class, inversedBy: 'scheduledCommands')]
    #[ORM\JoinColumn(name: 'owner_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    protected ?\Synolia\SyliusSchedulerCommandPlugin\Entity\CommandInterface $owner = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ScheduledCommandInterface
    {
        $this->name = $name;

        return $this;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function setCommand(string $command): ScheduledCommandInterface
    {
        $this->command = $command;

        return $this;
    }

    public function getArguments(): ?string
    {
        return $this->arguments;
    }

    public function setArguments(?string $arguments): ScheduledCommandInterface
    {
        $this->arguments = $arguments;

        return $this;
    }

    public function getExecutedAt(): ?\DateTime
    {
        return $this->executedAt;
    }

    public function setExecutedAt(?\DateTime $executedAt): ScheduledCommandInterface
    {
        $this->executedAt = $executedAt;

        return $this;
    }

    public function getLastReturnCode(): ?int
    {
        return $this->lastReturnCode;
    }

    public function setLastReturnCode(?int $lastReturnCode): ScheduledCommandInterface
    {
        $this->lastReturnCode = $lastReturnCode;

        return $this;
    }

    public function getLogFile(): ?string
    {
        return $this->logFile;
    }

    public function setLogFile(?string $logFile): ScheduledCommandInterface
    {
        $this->logFile = $logFile;

        return $this;
    }

    public function getCommandEndTime(): ?\DateTime
    {
        return $this->commandEndTime;
    }

    public function setCommandEndTime(?\DateTime $commandEndTime): ScheduledCommandInterface
    {
        $this->commandEndTime = $commandEndTime;

        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getOwner(): ?CommandInterface
    {
        return $this->owner;
    }

    public function setOwner(?CommandInterface $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getTimeout(): ?int
    {
        return $this->timeout;
    }

    public function setTimeout(?int $timeout): ScheduledCommandInterface
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function getIdleTimeout(): ?int
    {
        return $this->idleTimeout;
    }

    public function setIdleTimeout(?int $idleTimeout): ScheduledCommandInterface
    {
        $this->idleTimeout = $idleTimeout;

        return $this;
    }
}
