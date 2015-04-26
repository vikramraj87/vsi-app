<?php

namespace spec\Kivi;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CountBasedMergerSpec extends ObjectBehavior
{
    function it_merges_two_empty_arrays()
    {
        $this->merge([], [])->shouldReturn([]);
    }

    function it_merges_an_array_with_empty_array()
    {
        $this->merge(["a","b","c"], [])->shouldReturn(["a","b","c"]);
    }

    function it_merges_arrays_with_equal_count()
    {
        $this->merge(["a","b","c"], ["1","2","3"])->shouldReturn(["a", "1", "b", "2", "c", "3"]);
    }

    function it_merges_arrays_with_unequal_count()
    {
        $this->merge(["a", "b", "c", "d"], ["1", "2"])->shouldReturn(["a", "b", "1", "c", "d", "2"]);
    }

    function it_merges_arrays_with_unequal_undivisable_count()
    {
        $this->merge(["a", "b", "c", "d", "e", "f", "g"], ["1", "2", "3"])
             ->shouldReturn(["a", "b", "1", "c", "d", "2", "e", "f", "3", "g"]);
    }

    function it_merges_arrays_with_unequal_undivisable_count_2()
    {
        $this->merge(["1", "2", "3"], ["a", "b", "c", "d", "e"])
            ->shouldReturn(["a", "b", "1", "c", "d", "2", "e", "3"]);
    }

    function it_merges_arrays_with_unequal_count_2()
    {
        $this->merge(["1", "2"], ["a", "b", "c", "d"])->shouldReturn(["a", "b", "1", "c", "d", "2"]);
    }

    function it_merges_arrays_with_unequal_undivisable_count_3()
    {
        $this->merge(["1", "2", "3"], ["a", "b", "c", "d", "e", "f", "g"])
            ->shouldReturn(["a", "b", "1", "c", "d", "2", "e", "f", "3", "g"]);
    }

    function it_merges_arrays_with_unequal_undivisable_count_4()
    {
        $this->merge(["1", "2", "3"],["a", "b", "c", "d", "e"])
            ->shouldReturn(["a", "b", "1", "c", "d", "2", "e", "3"]);
    }
}
