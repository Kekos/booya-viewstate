<?php
/*!
 * Booya Framework (ViewState)
 * ViewState controller trait
 *
 * @version 1.0
 * @date 2016-03-20
 */

namespace Booya\ViewState;

trait ControllerTrait {
  protected $viewstate = null;

  private function initViewState() {
    if ($this->viewstate === null) {
      $this->viewstate = new ViewState();
    }
  }

  protected function viewState() {
    $this->initViewState();
    $this->set('flow_qs', $this->viewstate->getFlowQueryString());
    $this->set('origin_qs', $this->viewstate->getOriginQueryString());
  }

  protected function redirectToOrigin($url, $extra_qs = '') {
    $this->initViewState();

    $qs = $this->viewstate->getOriginQueryString();
    if ($extra_qs !== '') {
      $qs .= ($qs === '' ? '?' : '&');
    }

    $this->redirect($url . $qs);
  }
}
?>