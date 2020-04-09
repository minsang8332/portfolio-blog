<?php

namespace App\Service;

use App\Repository\PortfolioRepository;
use App\Repository\SkillRepository;
use App\Repository\WorkRepository;

/**
 * @author Yuu2
 * updated 2020.04.09
 */
class HomeService {

  /**
   * @var PortfolioRepository
   */
  private $portfolioRepository;

  /**
   * @var SkillRepository
   */
  private $skillRepository;

  /**
   * @var WorkRepository
   */
  private $workRepository;

  /**
   * @access public
   * @param PortfolioRepository $portfolioRepository
   * @param SkillRepository $skillRepository
   * @param WorkRepository $workRepository
   */
  public function __construct(
    PortfolioRepository $portfolioRepository,
    SkillRepository $skillRepository,
    WorkRepository $workRepository
  ) {
    $this->portfolioRepository = $portfolioRepository;
    $this->skillRepository = $skillRepository;
    $this->workRepository = $workRepository;
  }

  /**
   * @access public
   * @param int $count
   * @return array
   */
  public function renderPortfolios(int $count = 10): ?array {
    
    return $this->portfolioRepository->countPortfolios($count);
  }

  /**
   * @access public
   * @param int $count
   * @return array
   */
  public function renderSkills(int $count = 10): ?array {

    return $this->skillRepository->countSkills($count);
  }

  /**
   * @todo CRUD
   * @access public
   * @return object
   */
  public function renderWork(): ?object {
    
    return $this->workRepository->findOneBy([], []);
  }
}

