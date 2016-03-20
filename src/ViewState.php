<?php
/*!
 * Booya Framework (ViewState)
 * ViewState model
 *
 * @version 1.0
 * @date 2016-03-30
 */

namespace Booya\ViewState;

class ViewState {

  private $id = null;
  private $query_string = '';

  public function __construct() {
    $this->init();

    if (isset($_GET['flow'])) {
      $this->readFlow();
    } else {
      $this->persistFlow();
    }
  }

  private function init() {
    if (!isset($_SESSION['viewstate'])) {
      $_SESSION['viewstate'] = array(
        'next_id' => 0
      );
    }

    $this->purgeFlows();
  }

  private function purgeFlows() {
    foreach ($_SESSION['viewstate'] as $key => $flow) {
      // Purge every hour
      if ($key != 'next_id' && (time() - $flow[1] >= 60)) {
        unset($_SESSION['viewstate'][$key]);
      }
    }
  }

  private function getNextId() {
    $next_id = $_SESSION['viewstate']['next_id'];

    ++$_SESSION['viewstate']['next_id'];

    return $next_id;
  }

  private function readFlow() {
    $this->id = $_GET['flow'];
    unset($_GET['flow']);

    if (isset($_SESSION['viewstate'][$this->id])) {
      $this->query_string = $_SESSION['viewstate'][$this->id][0];
    }
  }

  private function persistFlow() {
    if (count($_GET) > 0) {
      $this->id = $this->getNextId();
      $_SESSION['viewstate'][$this->id] = array(
        http_build_query($_GET),
        time()
      );
    }
  }

  public function hasFlow() {
    return ($this->id !== null);
  }

  public function getFlowQueryString() {
    if ($this->id !== null) {
      return '?flow=' . $this->id;
    }

    return '';
  }

  public function getOriginQueryString() {
    if ($this->id !== null) {
      return '?' . $this->query_string . '&flow=' . $this->id;
    }

    return '';
  }
}
?>