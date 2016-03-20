# Viewstate Booya PHP framework

Remembers query string-parameters used to render one view when user is going
back to first view from another view.

## Install

You can install Booya ViewState via [Composer](http://getcomposer.org/):

```
composer require kekos/booya-viewstate
```

## API

Use the viewstate as trait:

```PHP
use Booya\LayoutController;
use Booya\ViewState\ControllerTrait as ViewStateTrait;

class IndexController extends LayoutController {
  use ViewStateTrait;

  public function index() {
    $this->viewState();
  }

  public function other_action() {
    $this->viewState();
  }
}
```

In view `index.php`:

```PHP
<a href="index/other_action<?php echo uh($flow_qs); ?>">Go to other view</a>
```

In view `other_action.php`:

```PHP
<a href="index<?php echo uh($origin_qs); ?>">Go back to first view</a>
```

### Redirect back to origin action

```PHP
$this->redirectToOrigin('index');
```

## Bugs and improvements

Report bugs in GitHub issues or feel free to make a pull request :-)

## License

MIT