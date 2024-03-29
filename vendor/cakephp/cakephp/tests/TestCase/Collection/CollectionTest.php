<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Test\TestCase\Collection;

use ArrayIterator;
use ArrayObject;
use Cake\Collection\Collection;
use Cake\TestSuite\TestCase;
use NoRewindIterator;

/**
 * CollectionTest
 *
 */
class CollectionTest extends TestCase
{

    /**
     * Tests that it is possible to convert an array into a collection
     *
     * @return void
     */
    public function testArrayIsWrapped()
    {
        $items = [1, 2, 3];
        $collection = new Collection($items);
        $this->assertEquals($items, iterator_to_array($collection));
    }

    /**
     * Tests that it is possible to convert an iterator into a collection
     *
     * @return void
     */
    public function testIteratorIsWrapped()
    {
        $items = new \ArrayObject([1, 2, 3]);
        $collection = new Collection($items);
        $this->assertEquals(iterator_to_array($items), iterator_to_array($collection));
    }

    /**
     * Test running a method over all elements in the collection
     *
     * @return void
     */
    public function testEeach()
    {
        $items = ['a' => 1, 'b' => 2, 'c' => 3];
        $collection = new Collection($items);
        $callable = $this->getMock('stdClass', ['__invoke']);
        $callable->expects($this->at(0))
            ->method('__invoke')
            ->with(1, 'a');
        $callable->expects($this->at(1))
            ->method('__invoke')
            ->with(2, 'b');
        $callable->expects($this->at(2))
            ->method('__invoke')
            ->with(3, 'c');
        $collection->each($callable);
    }

    /**
     * Test filter() with no callback.
     *
     * @return void
     */
    public function testFilterNoCallback()
    {
        $items = [1, 2, 0, 3, false, 4, null, 5, ''];
        $collection = new Collection($items);
        $result = $collection->filter()->toArray();
        $expected = [1, 2, 3, 4, 5];
        $this->assertEquals($expected, array_values($result));
    }

    /**
     * Tests that it is possible to chain filter() as it returns a collection object
     *
     * @return void
     */
    public function testFilterChaining()
    {
        $items = ['a' => 1, 'b' => 2, 'c' => 3];
        $collection = new Collection($items);
        $callable = $this->getMock('stdClass', ['__invoke']);
        $callable->expects($this->once())
            ->method('__invoke')
            ->with(3, 'c');
        $filtered = $collection->filter(function ($value, $key, $iterator) {
            return $value > 2;
        });

        $this->assertInstanceOf('Cake\Collection\Collection', $filtered);
        $filtered->each($callable);
    }

    /**
     * Tests reject
     *
     * @return void
     */
    public function testReject()
    {
        $items = ['a' => 1, 'b' => 2, 'c' => 3];
        $collection = new Collection($items);
        $result = $collection->reject(function ($v, $k, $items) use ($collection) {
            $this->assertSame($collection->getInnerIterator(), $items);
            return $v > 2;
        });
        $this->assertEquals(['a' => 1, 'b' => 2], iterator_to_array($result));
        $this->assertInstanceOf('Cake\Collection\Collection', $result);
    }

    /**
     * Tests every when the callback returns true for all elements
     *
     * @return void
     */
    public function testEveryReturnTrue()
    {
        $items = ['a' => 1, 'b' => 2, 'c' => 3];
        $collection = new Collection($items);
        $callable = $this->getMock('stdClass', ['__invoke']);
        $callable->expects($this->at(0))
            ->method('__invoke')
            ->with(1, 'a')
            ->will($this->returnValue(true));
        $callable->expects($this->at(1))
            ->method('__invoke')
            ->with(2, 'b')
            ->will($this->returnValue(true));
        $callable->expects($this->at(2))
            ->method('__invoke')
            ->with(3, 'c')
            ->will($this->returnValue(true));
        $this->assertTrue($collection->every($callable));
    }

    /**
     * Tests every when the callback returns false for one of the elements
     *
     * @return void
     */
    public function testEveryReturnFalse()
    {
        $items = ['a' => 1, 'b' => 2, 'c' => 3];
        $collection = new Collection($items);
        $callable = $this->getMock('stdClass', ['__invoke']);
        $callable->expects($this->at(0))
            ->method('__invoke')
            ->with(1, 'a')
            ->will($this->returnValue(true));
        $callable->expects($this->at(1))
            ->method('__invoke')
            ->with(2, 'b')
            ->will($this->returnValue(false));
        $callable->expects($this->exactly(2))->method('__invoke');
        $this->assertFalse($collection->every($callable));
    }

    /**
     * Tests some() when one of the calls return true
     *
     * @return void
     */
    public function testSomeReturnTrue()
    {
        $items = ['a' => 1, 'b' => 2, 'c' => 3];
        $collection = new Collection($items);
        $callable = $this->getMock('stdClass', ['__invoke']);
        $callable->expects($this->at(0))
            ->method('__invoke')
            ->with(1, 'a')
            ->will($this->returnValue(false));
        $callable->expects($this->at(1))
            ->method('__invoke')
            ->with(2, 'b')
            ->will($this->returnValue(true));
        $callable->expects($this->exactly(2))->method('__invoke');
        $this->assertTrue($collection->some($callable));
    }

    /**
     * Tests some() when none of the calls return true
     *
     * @return void
     */
    public function testSomeReturnFalse()
    {
        $items = ['a' => 1, 'b' => 2, 'c' => 3];
        $collection = new Collection($items);
        $callable = $this->getMock('stdClass', ['__invoke']);
        $callable->expects($this->at(0))
            ->method('__invoke')
            ->with(1, 'a')
            ->will($this->returnValue(false));
        $callable->expects($this->at(1))
            ->method('__invoke')
            ->with(2, 'b')
            ->will($this->returnValue(false));
        $callable->expects($this->at(2))
            ->method('__invoke')
            ->with(3, 'c')
            ->will($this->returnValue(false));
        $this->assertFalse($collection->some($callable));
    }

    /**
     * Tests contains
     *
     * @return void
     */
    public function testContains()
    {
        $items = ['a' => 1, 'b' => 2, 'c' => 3];
        $collection = new Collection($items);
        $this->assertTrue($collection->contains(2));
        $this->assertTrue($collection->contains(1));
        $this->assertFalse($collection->contains(10));
        $this->assertFalse($collection->contains('2'));
    }

    /**
     * Tests map
     *
     * @return void
     */
    public function testMap()
    {
        $items = ['a' => 1, 'b' => 2, 'c' => 3];
        $collection = new Collection($items);
        $map = $collection->map(function ($v, $k, $it) use ($collection) {
            $this->assertSame($collection->getInnerIterator(), $it);
            return $v * $v;
        });
        $this->assertInstanceOf('Cake\Collection\Iterator\ReplaceIterator', $map);
        $this->assertEquals(['a' => 1, 'b' => 4, 'c' => 9], iterator_to_array($map));
    }

    /**
     * Tests reduce with initial value
     *
     * @return void
     */
    public function testReduceWithInitialValue()
    {
        $items = ['a' => 1, 'b' => 2, 'c' => 3];
        $collection = new Collection($items);
        $callable = $this->getMock('stdClass', ['__invoke']);
        $callable->expects($this->at(0))
            ->method('__invoke')
            ->with(10, 1, 'a')
            ->will($this->returnValue(11));
        $callable->expects($this->at(1))
            ->method('__invoke')
            ->with(11, 2, 'b')
            ->will($this->returnValue(13));
        $callable->expects($this->at(2))
            ->method('__invoke')
            ->with(13, 3, 'c')
            ->will($this->returnValue(16));
        $this->assertEquals(16, $collection->reduce($callable, 10));
    }

    /**
     * Tests reduce without initial value
     *
     * @return void
     */
    public function testReduceWithoutInitialValue()
    {
        $items = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $collection = new Collection($items);
        $callable = $this->getMock('stdClass', ['__invoke']);
        $callable->expects($this->at(0))
            ->method('__invoke')
            ->with(1, 2, 'b')
            ->will($this->returnValue(3));
        $callable->expects($this->at(1))
            ->method('__invoke')
            ->with(3, 3, 'c')
            ->will($this->returnValue(6));
        $callable->expects($this->at(2))
            ->method('__invoke')
            ->with(6, 4, 'd')
            ->will($this->returnValue(10));
        $this->assertEquals(10, $collection->reduce($callable));
    }

    /**
     * Tests extract
     *
     * @return void
     */
    public function testExtract()
    {
        $items = [['a' => ['b' => ['c' => 1]]], 2];
        $collection = new Collection($items);
        $map = $collection->extract('a.b.c');
        $this->assertInstanceOf('Cake\Collection\Iterator\ExtractIterator', $map);
        $this->assertEquals([1, null], iterator_to_array($map));
    }

    /**
     * Tests sort
     *
     * @return void
     */
    public function testSortString()
    {
        $items = [
            ['a' => ['b' => ['c' => 4]]],
            ['a' => ['b' => ['c' => 10]]],
            ['a' => ['b' => ['c' => 6]]]
        ];
        $collection = new Collection($items);
        $map = $collection->sortBy('a.b.c');
        $this->assertInstanceOf('Cake\Collection\Collection', $map);
        $expected = [
            ['a' => ['b' => ['c' => 10]]],
            ['a' => ['b' => ['c' => 6]]],
            ['a' => ['b' => ['c' => 4]]],
        ];
        $this->assertEquals($expected, $map->toList());
    }

    /**
     * Tests max
     *
     * @return void
     */
    public function testMax()
    {
        $items = [
            ['a' => ['b' => ['c' => 4]]],
            ['a' => ['b' => ['c' => 10]]],
            ['a' => ['b' => ['c' => 6]]]
        ];
        $collection = new Collection($items);
        $this->assertEquals(['a' => ['b' => ['c' => 10]]], $collection->max('a.b.c'));

        $callback = function ($e) {
            return $e['a']['b']['c'] * - 1;
        };
        $this->assertEquals(['a' => ['b' => ['c' => 4]]], $collection->max($callback));
    }

    /**
     * Tests min
     *
     * @return void
     */
    public function testMin()
    {
        $items = [
            ['a' => ['b' => ['c' => 4]]],
            ['a' => ['b' => ['c' => 10]]],
            ['a' => ['b' => ['c' => 6]]]
        ];
        $collection = new Collection($items);
        $this->assertEquals(['a' => ['b' => ['c' => 4]]], $collection->min('a.b.c'));
    }

    /**
     * Tests groupBy
     *
     * @return void
     */
    public function testGroupBy()
    {
        $items = [
            ['id' => 1, 'name' => 'foo', 'parent_id' => 10],
            ['id' => 2, 'name' => 'bar', 'parent_id' => 11],
            ['id' => 3, 'name' => 'baz', 'parent_id' => 10],
        ];
        $collection = new Collection($items);
        $grouped = $collection->groupBy('parent_id');
        $expected = [
            10 => [
                ['id' => 1, 'name' => 'foo', 'parent_id' => 10],
                ['id' => 3, 'name' => 'baz', 'parent_id' => 10],
            ],
            11 => [
                ['id' => 2, 'name' => 'bar', 'parent_id' => 11],
            ]
        ];
        $this->assertEquals($expected, iterator_to_array($grouped));
        $this->assertInstanceOf('Cake\Collection\Collection', $grouped);

        $grouped = $collection->groupBy(function ($element) {
            return $element['parent_id'];
        });
        $this->assertEquals($expected, iterator_to_array($grouped));
    }

    /**
     * Tests grouping by a deep key
     *
     * @return void
     */
    public function testGroupByDeepKey()
    {
        $items = [
            ['id' => 1, 'name' => 'foo', 'thing' => ['parent_id' => 10]],
            ['id' => 2, 'name' => 'bar', 'thing' => ['parent_id' => 11]],
            ['id' => 3, 'name' => 'baz', 'thing' => ['parent_id' => 10]],
        ];
        $collection = new Collection($items);
        $grouped = $collection->groupBy('thing.parent_id');
        $expected = [
            10 => [
                ['id' => 1, 'name' => 'foo', 'thing' => ['parent_id' => 10]],
                ['id' => 3, 'name' => 'baz', 'thing' => ['parent_id' => 10]],
            ],
            11 => [
                ['id' => 2, 'name' => 'bar', 'thing' => ['parent_id' => 11]],
            ]
        ];
        $this->assertEquals($expected, iterator_to_array($grouped));
    }

    /**
     * Tests indexBy
     *
     * @return void
     */
    public function testIndexBy()
    {
        $items = [
            ['id' => 1, 'name' => 'foo', 'parent_id' => 10],
            ['id' => 2, 'name' => 'bar', 'parent_id' => 11],
            ['id' => 3, 'name' => 'baz', 'parent_id' => 10],
        ];
        $collection = new Collection($items);
        $grouped = $collection->indexBy('id');
        $expected = [
            1 => ['id' => 1, 'name' => 'foo', 'parent_id' => 10],
            3 => ['id' => 3, 'name' => 'baz', 'parent_id' => 10],
            2 => ['id' => 2, 'name' => 'bar', 'parent_id' => 11],
        ];
        $this->assertEquals($expected, iterator_to_array($grouped));
        $this->assertInstanceOf('Cake\Collection\Collection', $grouped);

        $grouped = $collection->indexBy(function ($element) {
            return $element['id'];
        });
        $this->assertEquals($expected, iterator_to_array($grouped));
    }

    /**
     * Tests indexBy with a deep property
     *
     * @return void
     */
    public function testIndexByDeep()
    {
        $items = [
            ['id' => 1, 'name' => 'foo', 'thing' => ['parent_id' => 10]],
            ['id' => 2, 'name' => 'bar', 'thing' => ['parent_id' => 11]],
            ['id' => 3, 'name' => 'baz', 'thing' => ['parent_id' => 10]],
        ];
        $collection = new Collection($items);
        $grouped = $collection->indexBy('thing.parent_id');
        $expected = [
            10 => ['id' => 3, 'name' => 'baz', 'thing' => ['parent_id' => 10]],
            11 => ['id' => 2, 'name' => 'bar', 'thing' => ['parent_id' => 11]],
        ];
        $this->assertEquals($expected, iterator_to_array($grouped));
    }

    /**
     * Tests countBy
     *
     * @return void
     */
    public function testCountBy()
    {
        $items = [
            ['id' => 1, 'name' => 'foo', 'parent_id' => 10],
            ['id' => 2, 'name' => 'bar', 'parent_id' => 11],
            ['id' => 3, 'name' => 'baz', 'parent_id' => 10],
        ];
        $collection = new Collection($items);
        $grouped = $collection->countBy('parent_id');
        $expected = [
            10 => 2,
            11 => 1
        ];
        $this->assertEquals($expected, iterator_to_array($grouped));
        $this->assertInstanceOf('Cake\Collection\Collection', $grouped);

        $grouped = $collection->countBy(function ($element) {
            return $element['parent_id'];
        });
        $this->assertEquals($expected, iterator_to_array($grouped));
    }

    /**
     * Tests shuffle
     *
     * @return void
     */
    public function testShuffle()
    {
        $data = [1, 2, 3, 4];
        $collection = (new Collection($data))->shuffle();
        $this->assertEquals(count($data), count(iterator_to_array($collection)));

        foreach ($collection as $value) {
            $this->assertContains($value, $data);
        }
    }

    /**
     * Tests sample
     *
     * @return void
     */
    public function testSample()
    {
        $data = [1, 2, 3, 4];
        $collection = (new Collection($data))->sample(2);
        $this->assertEquals(2, count(iterator_to_array($collection)));

        foreach ($collection as $value) {
            $this->assertContains($value, $data);
        }
    }

    /**
     * Test toArray method
     *
     * @return void
     */
    public function testToArray()
    {
        $data = [1, 2, 3, 4];
        $collection = new Collection($data);
        $this->assertEquals($data, $collection->toArray());
    }

    /**
     * Test toList method
     *
     * @return void
     */
    public function testToList()
    {
        $data = [100 => 1, 300 => 2, 500 => 3, 1 => 4];
        $collection = new Collection($data);
        $this->assertEquals(array_values($data), $collection->toList());
    }

    /**
     * Test json encoding
     *
     * @return void
     */
    public function testToJson()
    {
        $data = [1, 2, 3, 4];
        $collection = new Collection($data);
        $this->assertEquals(json_encode($data), json_encode($collection));
    }

    /**
     * Tests that only arrays and Traversables are allowed in the constructor
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Only an array or \Traversable is allowed for Collection
     * @return void
     */
    public function testInvalidConstructorArgument()
    {
        new Collection('Derp');
    }

    /**
     * Tests take method
     *
     * @return void
     */
    public function testTake()
    {
        $data = [1, 2, 3, 4];
        $collection = new Collection($data);

        $taken = $collection->take(2);
        $this->assertEquals([1, 2], $taken->toArray());

        $taken = $collection->take(3);
        $this->assertEquals([1, 2, 3], $taken->toArray());

        $taken = $collection->take(500);
        $this->assertEquals([1, 2, 3, 4], $taken->toArray());

        $taken = $collection->take(1);
        $this->assertEquals([1], $taken->toArray());

        $taken = $collection->take();
        $this->assertEquals([1], $taken->toArray());

        $taken = $collection->take(2, 2);
        $this->assertEquals([2 => 3, 3 => 4], $taken->toArray());
    }

    /**
     * Tests match
     *
     * @return void
     */
    public function testMatch()
    {
        $items = [
            ['id' => 1, 'name' => 'foo', 'thing' => ['parent_id' => 10]],
            ['id' => 2, 'name' => 'bar', 'thing' => ['parent_id' => 11]],
            ['id' => 3, 'name' => 'baz', 'thing' => ['parent_id' => 10]],
        ];
        $collection = new Collection($items);
        $matched = $collection->match(['thing.parent_id' => 10, 'name' => 'baz']);
        $this->assertEquals([2 => $items[2]], $matched->toArray());

        $matched = $collection->match(['thing.parent_id' => 10]);
        $this->assertEquals(
            [0 => $items[0], 2 => $items[2]],
            $matched->toArray()
        );

        $matched = $collection->match(['thing.parent_id' => 500]);
        $this->assertEquals([], $matched->toArray());

        $matched = $collection->match(['parent_id' => 10, 'name' => 'baz']);
        $this->assertEquals([], $matched->toArray());
    }

    /**
     * Tests firstMatch
     *
     * @return void
     */
    public function testFirstMatch()
    {
        $items = [
            ['id' => 1, 'name' => 'foo', 'thing' => ['parent_id' => 10]],
            ['id' => 2, 'name' => 'bar', 'thing' => ['parent_id' => 11]],
            ['id' => 3, 'name' => 'baz', 'thing' => ['parent_id' => 10]],
        ];
        $collection = new Collection($items);
        $matched = $collection->firstMatch(['thing.parent_id' => 10]);
        $this->assertEquals(
            ['id' => 1, 'name' => 'foo', 'thing' => ['parent_id' => 10]],
            $matched
        );

        $matched = $collection->firstMatch(['thing.parent_id' => 10, 'name' => 'baz']);
        $this->assertEquals(
            ['id' => 3, 'name' => 'baz', 'thing' => ['parent_id' => 10]],
            $matched
        );
    }

    /**
     * Tests the append method
     *
     * @return void
     */
    public function testAppend()
    {
        $collection = new Collection([1, 2, 3]);
        $combined = $collection->append([4, 5, 6]);
        $this->assertEquals([1, 2, 3, 4, 5, 6], $combined->toArray(false));

        $collection = new Collection(['a' => 1, 'b' => 2]);
        $combined = $collection->append(['c' => 3, 'a' => 4]);
        $this->assertEquals(['a' => 4, 'b' => 2, 'c' => 3], $combined->toArray());
    }

    /**
     * Tests that by calling compile internal iteration operations are not done
     * more than once
     *
     * @return void
     */
    public function testCompile()
    {
        $items = ['a' => 1, 'b' => 2, 'c' => 3];
        $collection = new Collection($items);
        $callable = $this->getMock('stdClass', ['__invoke']);
        $callable->expects($this->at(0))
            ->method('__invoke')
            ->with(1, 'a')
            ->will($this->returnValue(4));
        $callable->expects($this->at(1))
            ->method('__invoke')
            ->with(2, 'b')
            ->will($this->returnValue(5));
        $callable->expects($this->at(2))
            ->method('__invoke')
            ->with(3, 'c')
            ->will($this->returnValue(6));
        $compiled = $collection->map($callable)->compile();
        $this->assertEquals(['a' => 4, 'b' => 5, 'c' => 6], $compiled->toArray());
        $this->assertEquals(['a' => 4, 'b' => 5, 'c' => 6], $compiled->toArray());
    }

    /**
     * Tests converting a non rewindable iterator into a rewindable one using
     * the buffered method.
     *
     * @return void
     */
    public function testBuffered()
    {
        $items = new NoRewindIterator(new ArrayIterator(['a' => 4, 'b' => 5, 'c' => 6]));
        $buffered = (new Collection($items))->buffered();
        $this->assertEquals(['a' => 4, 'b' => 5, 'c' => 6], $buffered->toArray());
        $this->assertEquals(['a' => 4, 'b' => 5, 'c' => 6], $buffered->toArray());
    }

    /**
     * Tests the combine method
     *
     * @return void
     */
    public function testCombine()
    {
        $items = [
            ['id' => 1, 'name' => 'foo', 'parent' => 'a'],
            ['id' => 2, 'name' => 'bar', 'parent' => 'b'],
            ['id' => 3, 'name' => 'baz', 'parent' => 'a']
        ];
        $collection = (new Collection($items))->combine('id', 'name');
        $expected = [1 => 'foo', 2 => 'bar', 3 => 'baz'];
        $this->assertEquals($expected, $collection->toArray());

        $expected = ['foo' => 1, 'bar' => 2, 'baz' => 3];
        $collection = (new Collection($items))->combine('name', 'id');
        $this->assertEquals($expected, $collection->toArray());

        $collection = (new Collection($items))->combine('id', 'name', 'parent');
        $expected = ['a' => [1 => 'foo', 3 => 'baz'], 'b' => [2 => 'bar']];
        $this->assertEquals($expected, $collection->toArray());

        $expected = [
            '0-1' => ['foo-0-1' => '0-1-foo'],
            '1-2' => ['bar-1-2' => '1-2-bar'],
            '2-3' => ['baz-2-3' => '2-3-baz']
        ];
        $collection = (new Collection($items))->combine(
            function ($value, $key) {
                return $value['name'] . '-' . $key;
            },
            function ($value, $key) {
                return $key . '-' . $value['name'];
            },
            function ($value, $key) {
                return $key . '-' . $value['id'];
            }
        );
        $this->assertEquals($expected, $collection->toArray());

        $collection = (new Collection($items))->combine('id', 'crazy');
        $this->assertEquals([1 => null, 2 => null, 3 => null], $collection->toArray());
    }

    /**
     * Tests the nest method with only one level
     *
     * @return void
     */
    public function testNest()
    {
        $items = [
            ['id' => 1, 'parent_id' => null],
            ['id' => 2, 'parent_id' => 1],
            ['id' => 3, 'parent_id' => 1],
            ['id' => 4, 'parent_id' => 1],
            ['id' => 5, 'parent_id' => 6],
            ['id' => 6, 'parent_id' => null],
            ['id' => 7, 'parent_id' => 1],
            ['id' => 8, 'parent_id' => 6],
            ['id' => 9, 'parent_id' => 6],
            ['id' => 10, 'parent_id' => 6]
        ];
        $collection = (new Collection($items))->nest('id', 'parent_id');
        $expected = [
            [
                'id' => 1,
                'parent_id' => null,
                'children' => [
                    ['id' => 2, 'parent_id' => 1, 'children' => []],
                    ['id' => 3, 'parent_id' => 1, 'children' => []],
                    ['id' => 4, 'parent_id' => 1, 'children' => []],
                    ['id' => 7, 'parent_id' => 1, 'children' => []]
                ]
            ],
            [
                'id' => 6,
                'parent_id' => null,
                'children' => [
                    ['id' => 5, 'parent_id' => 6, 'children' => []],
                    ['id' => 8, 'parent_id' => 6, 'children' => []],
                    ['id' => 9, 'parent_id' => 6, 'children' => []],
                    ['id' => 10, 'parent_id' => 6, 'children' => []]
                ]
            ]
        ];
        $this->assertEquals($expected, $collection->toArray());
    }

    /**
     * Tests the nest method with more than one level
     *
     * @return void
     */
    public function testNestMultiLevel()
    {
        $items = [
            ['id' => 1, 'parent_id' => null],
            ['id' => 2, 'parent_id' => 1],
            ['id' => 3, 'parent_id' => 2],
            ['id' => 4, 'parent_id' => 2],
            ['id' => 5, 'parent_id' => 3],
            ['id' => 6, 'parent_id' => null],
            ['id' => 7, 'parent_id' => 3],
            ['id' => 8, 'parent_id' => 4],
            ['id' => 9, 'parent_id' => 6],
            ['id' => 10, 'parent_id' => 6]
        ];
        $collection = (new Collection($items))->nest('id', 'parent_id');
        $expected = [
            [
                'id' => 1,
                'parent_id' => null,
                'children' => [
                    [
                        'id' => 2,
                        'parent_id' => 1,
                        'children' => [
                            [
                                'id' => 3,
                                'parent_id' => 2,
                                'children' => [
                                    ['id' => 5, 'parent_id' => 3, 'children' => []],
                                    ['id' => 7, 'parent_id' => 3, 'children' => []]
                                ]
                            ],
                            [
                                'id' => 4,
                                'parent_id' => 2,
                                'children' => [
                                    ['id' => 8, 'parent_id' => 4, 'children' => []]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            [
                'id' => 6,
                'parent_id' => null,
                'children' => [
                    ['id' => 9, 'parent_id' => 6, 'children' => []],
                    ['id' => 10, 'parent_id' => 6, 'children' => []]
                ]
            ]
        ];
        $this->assertEquals($expected, $collection->toArray());
    }

    /**
     * Tests the nest method with more than one level
     *
     * @return void
     */
    public function testNestObjects()
    {
        $items = [
            new ArrayObject(['id' => 1, 'parent_id' => null]),
            new ArrayObject(['id' => 2, 'parent_id' => 1]),
            new ArrayObject(['id' => 3, 'parent_id' => 2]),
            new ArrayObject(['id' => 4, 'parent_id' => 2]),
            new ArrayObject(['id' => 5, 'parent_id' => 3]),
            new ArrayObject(['id' => 6, 'parent_id' => null]),
            new ArrayObject(['id' => 7, 'parent_id' => 3]),
            new ArrayObject(['id' => 8, 'parent_id' => 4]),
            new ArrayObject(['id' => 9, 'parent_id' => 6]),
            new ArrayObject(['id' => 10, 'parent_id' => 6])
        ];
        $collection = (new Collection($items))->nest('id', 'parent_id');
        $expected = [
            new ArrayObject([
                'id' => 1,
                'parent_id' => null,
                'children' => [
                    new ArrayObject([
                        'id' => 2,
                        'parent_id' => 1,
                        'children' => [
                            new ArrayObject([
                                'id' => 3,
                                'parent_id' => 2,
                                'children' => [
                                    new ArrayObject(['id' => 5, 'parent_id' => 3, 'children' => []]),
                                    new ArrayObject(['id' => 7, 'parent_id' => 3, 'children' => []])
                                ]
                            ]),
                            new ArrayObject([
                                'id' => 4,
                                'parent_id' => 2,
                                'children' => [
                                    new ArrayObject(['id' => 8, 'parent_id' => 4, 'children' => []])
                                ]
                            ])
                        ]
                    ])
                ]
            ]),
            new ArrayObject([
                'id' => 6,
                'parent_id' => null,
                'children' => [
                    new ArrayObject(['id' => 9, 'parent_id' => 6, 'children' => []]),
                    new ArrayObject(['id' => 10, 'parent_id' => 6, 'children' => []])
                ]
            ])
        ];
        $this->assertEquals($expected, $collection->toArray());
    }

    /**
     * Tests insert
     *
     * @return void
     */
    public function testInsert()
    {
        $items = [['a' => 1], ['b' => 2]];
        $collection = new Collection($items);
        $iterator = $collection->insert('c', [3, 4]);
        $this->assertInstanceOf('Cake\Collection\Iterator\InsertIterator', $iterator);
        $this->assertEquals(
            [['a' => 1, 'c' => 3], ['b' => 2, 'c' => 4]],
            iterator_to_array($iterator)
        );
    }

    /**
     * Provider for testing each of the directions for listNested
     *
     * @return void
     */
    public function nestedListProvider()
    {
        return [
            ['desc', [1, 2, 3, 5, 7, 4, 8, 6, 9, 10]],
            ['asc', [5, 7, 3, 8, 4, 2, 1, 9, 10, 6]],
            ['leaves', [5, 7, 8, 9, 10]]
        ];
    }

    /**
     * Tests the listNested method with the default 'children' nesting key
     *
     * @dataProvider nestedListProvider
     * @return void
     */
    public function testListNested($dir, $expected)
    {
        $items = [
            ['id' => 1, 'parent_id' => null],
            ['id' => 2, 'parent_id' => 1],
            ['id' => 3, 'parent_id' => 2],
            ['id' => 4, 'parent_id' => 2],
            ['id' => 5, 'parent_id' => 3],
            ['id' => 6, 'parent_id' => null],
            ['id' => 7, 'parent_id' => 3],
            ['id' => 8, 'parent_id' => 4],
            ['id' => 9, 'parent_id' => 6],
            ['id' => 10, 'parent_id' => 6]
        ];
        $collection = (new Collection($items))->nest('id', 'parent_id')->listNested($dir);
        $this->assertEquals($expected, $collection->extract('id')->toArray(false));
    }

    /**
     * Tests using listNested with a different nesting key
     *
     * @return void
     */
    public function testListNestedCustomKey()
    {
        $items = [
            ['id' => 1, 'stuff' => [['id' => 2, 'stuff' => [['id' => 3]]]]],
            ['id' => 4, 'stuff' => [['id' => 5]]]
        ];
        $collection = (new Collection($items))->listNested('desc', 'stuff');
        $this->assertEquals(range(1, 5), $collection->extract('id')->toArray(false));
    }

    /**
     * Tests flattening the collection using a custom callable function
     *
     * @return void
     */
    public function testListNestedWithCallable()
    {
        $items = [
            ['id' => 1, 'stuff' => [['id' => 2, 'stuff' => [['id' => 3]]]]],
            ['id' => 4, 'stuff' => [['id' => 5]]]
        ];
        $collection = (new Collection($items))->listNested('desc', function ($item) {
            return isset($item['stuff']) ? $item['stuff'] : [];
        });
        $this->assertEquals(range(1, 5), $collection->extract('id')->toArray(false));
    }

    /**
     * Tests the sumOf method
     *
     * @return void
     */
    public function testSumOf()
    {
        $items = [
            ['invoice' => ['total' => 100]],
            ['invoice' => ['total' => 200]]
        ];
        $this->assertEquals(300, (new Collection($items))->sumOf('invoice.total'));

        $sum = (new Collection($items))->sumOf(function ($v) {
            return $v['invoice']['total'] * 2;
        });
        $this->assertEquals(600, $sum);
    }

    /**
     * Tests the stopWhen method with a callable
     *
     * @return void
     */
    public function testStopWhenCallable()
    {
        $items = [10, 20, 40, 10, 5];
        $collection = (new Collection($items))->stopWhen(function ($v) {
            return $v > 20;
        });
        $this->assertEquals([10, 20], $collection->toArray());
    }

    /**
     * Tests the stopWhen method with a matching array
     *
     * @return void
     */
    public function testStopWhenWithArray()
    {
        $items = [
            ['foo' => 'bar'],
            ['foo' => 'baz'],
            ['foo' => 'foo']
        ];
        $collection = (new Collection($items))->stopWhen(['foo' => 'baz']);
        $this->assertEquals([['foo' => 'bar']], $collection->toArray());
    }

    /**
     * Tests the unfold method
     *
     * @return void
     */
    public function testUnfold()
    {
        $items = [
            [1, 2, 3, 4],
            [5, 6],
            [7, 8]
        ];

        $collection = (new Collection($items))->unfold();
        $this->assertEquals(range(1, 8), $collection->toArray(false));

        $items = [
            [1, 2],
            new Collection([3, 4])
        ];
        $collection = (new Collection($items))->unfold();
        $this->assertEquals(range(1, 4), $collection->toArray(false));
    }

    /**
     * Tests the unfold method with empty levels
     *
     * @return void
     */
    public function testUnfoldEmptyLevels()
    {
        $items = [[], [1, 2], []];
        $collection = (new Collection($items))->unfold();
        $this->assertEquals(range(1, 2), $collection->toArray(false));

        $items = [];
        $collection = (new Collection($items))->unfold();
        $this->assertEmpty($collection->toArray(false));
    }

    /**
     * Tests the unfold when passing a callable
     *
     * @return void
     */
    public function testUnfoldWithCallable()
    {
        $items = [1, 2, 3];
        $collection = (new Collection($items))->unfold(function ($item) {
            return range($item, $item * 2);
        });
        $expected = [1, 2, 2, 3, 4, 3, 4, 5, 6];
        $this->assertEquals($expected, $collection->toArray(false));
    }

    /**
     * Tests the through() method
     *
     * @return void
     */
    public function testThrough()
    {
        $items = [1, 2, 3];
        $collection = (new Collection($items))->through(function ($collection) {
            return $collection->append($collection->toList());
        });

        $this->assertEquals([1, 2, 3, 1, 2, 3], $collection->toList());
    }

    /**
     * Tests the through method when it returns an array
     *
     * @return void
     */
    public function testThroughReturnArray()
    {
        $items = [1, 2, 3];
        $collection = (new Collection($items))->through(function ($collection) {
            $list = $collection->toList();
            return array_merge($list, $list);
        });

        $this->assertEquals([1, 2, 3, 1, 2, 3], $collection->toList());
    }
}
