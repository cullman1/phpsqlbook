<?php

class CMS
{
  private $configuration;
  private $pdo;

  private $articleManager;
  private $categoryManager;
  private $imageManager;
  private $userManager;

  public function __construct($configuration)
  {
    $this->configuration = $configuration;
  }

  public function getPDO()
  {
    if ($this->pdo === null) {
        try {
            $this->pdo = new PDO($this->configuration['dsn'], $this->configuration['username'], $this->configuration['password']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $exeception) {
           // Utilities::errorPage('server-not-available.php');
           echo $exeception;
        }
    }
    return $this->pdo;
  }

  public function getCategoryManager()
  {
    if ($this->categoryManager === null) {
      $this->categoryManager = new CategoryManager($this->getPDO());
    }
    return $this->categoryManager;
  }

  public function getArticleManager()
  {
    if ($this->articleManager === null) {
      $this->articleManager = new ArticleManager($this->getPDO());
    }
    return $this->articleManager;
  }

  public function getUserManager()
  {
    if ($this->userManager === null) {
      $this->userManager = new UserManager($this->getPDO());
    }
    return $this->userManager;
  }

  public function getImageManager()
  {
    if ($this->imageManager === null) {
      $this->imageManager = new ImageManager($this->getPDO());
    }
    return $this->imageManager;
  }
}