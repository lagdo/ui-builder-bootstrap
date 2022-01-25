<?php

if (function_exists('jaxon')) {
    $di = jaxon()->di();
    // Register the UI builders
    $di->auto(Lagdo\UiBuilder\Bootstrap\Bootstrap3\Builder::class);
    $di->alias('dbadmin_builder_bootstrap3', Lagdo\UiBuilder\Bootstrap\Bootstrap3\Builder::class);
    $di->auto(Lagdo\UiBuilder\Bootstrap\Bootstrap4\Builder::class);
    $di->alias('dbadmin_builder_bootstrap4', Lagdo\UiBuilder\Bootstrap\Bootstrap4\Builder::class);
}
