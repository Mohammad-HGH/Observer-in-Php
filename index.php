<?php


interface IObserver
{
    public function render();
}

interface IObservable
{
    public function publisher();
}

//Observable
class A implements IObservable
{
    protected Station $dispatcher;

    public function __construct()
    {
        $this->dispatcher = new Station();
        $this->dispatcher->register('publish', new B);
        $this->dispatcher->register('publish', new C);
    }

    public function publisher()
    {
        $this->dispatcher->notify('publish');
    }

}
//-------------------------------------------------------
//BRIDGE DESIGN PATTERN
//-------------------------------------------------------


//Abstraction
class Station
{
    protected array $listeners = [];

    public function notify($event): void
    {
        foreach ($this->listeners[$event] as $listener) {

            $listener->render();
        }
    }

    public function register($event, IObserver $observer)
    {
        $this->listeners[$event][] = $observer;
    }

    public function unregister($event)
    {
        unset($this->listeners[$event]);
    }

}

// Implementation
class B implements IObserver
{
    public function render()
    {
        echo "I handle B class sir!";
    }
}
class C implements IObserver
{
    public function render()
    {
        echo "I handle C class sir!";
    }
}


$a = new A();
$a->publisher();
