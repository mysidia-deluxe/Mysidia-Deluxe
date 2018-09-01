<?php

namespace Resource\Collection;

use Resource\Native\Objective;
use Resource\Native\Mynull;
use Resource\Utility\Comparative;
use Resource\Exception\NosuchElementException;
use Resource\Exception\UnsupportedOperationException;

/**
 * The TreeMap Class, extending from the abstract Map Class and implementing the NavigableMappable Interface.
 * It is a Red-Black Tree based map implementation, can order objects stored in the Map.
 * @category Resource
 * @package Collection
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */
 
class TreeMap extends Map implements NavigableMappable
{

    /**
     * serialID constant, it serves as identifier of the object being TreeMap.
     */
    const SERIALID = "919286545866124006L";

    /**
     * red constant, it defines the red constant for red-black mechanism.
     */
    const RED = false;
    
    /**
     * black constant, it defines the black constant for red-black mechanism.
     */
    const BLACK = true;
    
    /**
     * The comparator property, it specifies the comparator object used to maintain order in this TreeMap.
     * @access private
     * @var Comparative
    */
    private $comparator;

    /**
     * The descendingMap property, it holds a reference to the Descending Map of this TreeMap.
     * @access private
     * @var NavigableMappable
     */
    private $descendingMap;
    
    /**
     * The dummy property, it defines a dummy Null Object for future operations.
     * @access private
     * @var Null
    */
    private $dummy;
    
    /**
     * The entrySet property, it stores a Set representing entries inside the TreeMap.
     * @access private
     * @var EntrySet
     */
    private $entrySet;

    /**
     * The navigableKeySet property, it stores a NavigableSet representing keys inside the TreeMap.
     * @access private
     * @var KeySet
     */
    private $navigableKeySet;
    
    /**
     * The root property, it stores the root entry of the TreeMap.
     * @access private
     * @var TreeMapEntry
     */
    private $root;

    /**
     * The size property, it specifies the current size of the Entrys inside the TreeMap.
     * @access private
     * @var Int
     */
    private $size;
    
    /**
     * Constructor of TreeMap Class, it initializes the TreeMap given another map and/or a comparator object.
     * @param Mappable  $map
     * @param Comparative  $comparator
     * @access public
     * @return Void
     */
    public function __construct(Mappable $map = null, Comparative $comparator = null)
    {
        if ($comparator != null) {
            $this->comparator = $comparator;
        }
        if ($map != null) {
            if ($map instanceof SortedMappable) {
                $this->comparator = $map->comparator();
                $this->build($map->size(), $map->iterator());
            } else {
                $this->putAll($map);
            }
        }
        $this->dummy = new Mynull;
    }

    /**
     * The addSet method, it is called from TreeSet to add elements.
     * @param SortedSettable  $set
     * @param Objective  $default
     * @access public
     * @return MapEntry
     */
    public function addSet(SortedSettable $set, Objective $default = null)
    {
        $this->build($set->getSize(), $set->iterator(), $default);
    }
    
    /**
     * The build method, a linear time tree building algorithm from sorted data.
     * If default value is not NULL, it will be used for each value in the map.
     * @param Int  $size
     * @param Iterator  $iterator
     * @param Objective  $default
     * @access private
     * @return Void
     */
    private function build($size = 0, Iterator $iterator = null, Objective $default = null)
    {
        $this->size = $size;
        $this->root = $this->buildTree(0, 0, $size - 1, $this->computeRedLevel($size), $iterator, $default);
    }

    /**
     * The buildTree method, it is a recursive helper method that does the real work of the build method.
     * @param Int  $level
     * @param Int  $lower
     * @param Int  $higher
     * @param Int  $redLevel
     * @param Iterator  $iterator
     * @param Objective  $default
     * @access private
     * @return MapEntry
     */
    private function buildTree($level = 0, $lower = 0, $higher = 0, $redLevel = 0, Iterator $iterator = null, Objective $default = null)
    {
        if ($lower > $higher) {
            return null;
        }
        $mid = ($lower + $higher) >> 1;
        $left = null;
        if ($lower < $mid) {
            $left = $this->buildTree($level + 1, $lower, $mid - 1, $redLevel, $iterator, $default);
        }
         
        if ($iterator != null) {
            if ($default == null) {
                $entry = $iterator->next();
                $key = $entry->getKey();
                $value = $entry->getValue();
            } else {
                $key = $iterator->next();
                $value = $default;
            }
        } else {
            throw new UnsupportedOperationException;
        }

        $middle = new TreeMapEntry($key, $value, null);
        if ($level == $redLevel) {
            $middle->setColor(self::RED);
        }
        if ($left != null) {
            $middle->setLeft($left);
            $left->setParent($middle);
        }
        if ($mid < $higher) {
            $right = $this->buildTree($level + 1, $mid + 1, $higher, $redLevel, $iterator, $default);
            $middle->setRight($right);
            $right->setParent($middle);
        }
        return $middle;
    }

    /**
     * The ceilingEntry method, returns an entry associated with the least key greater than or equal to the given key.
     * @param Objective  $key
     * @access public
     * @return MapEntry
     */
    public function ceilingEntry(Objective $key)
    {
        return $this->exportEntry($this->getCeilingEntry($key));
    }

    /**
     * The ceilingKey method, acquires the least key greater than or equal to the given key.
     * @param Objective  $key
     * @access public
     * @return Objective
     */
    public function ceilingKey(Objective $key)
    {
        return $this->key($this->getCeilingKey($key), true);
    }
    
    /**
     * The clear method, drops all key-value pairs currently stored in this TreeMap.
     * @access public
     * @return Void
     */
    public function clear()
    {
        $this->size = 0;
        $this->root = null;
    }

    /**
     * The colorOf method, acquires the color of the given entry.
     * @param Entry  $entry
     * @access private
     * @return Boolean
     */
    private function colorOf(Entry $entry = null)
    {
        return (($entry == null)?self::BLACK:$entry->getColor());
    }
    
    /**
     * The comparator method, returns the comparator object used to order the keys in this TreeMap.
     * @access public
     * @return Comparative
     */
    public function comparator()
    {
        return $this->comparator;
    }

    /**
     * The compare method, compares two keys using the correct comparison method for this TreeMap.
     * This is a final method, and thus cannot be overriden by child class.
     * @param Objective  $key
     * @param Objective  $key2
     * @access public
     * @return Int
     * @final
     */
    final public function compare(Objective $key, Objective $key2)
    {
        return (($this->comparator == null)?$key->compareTo($key2):$this->comparator->compare($key, $key2));
    }

    /**
     * The computeRedLevel method, find the level down to which to assign all nodes BLACK.
     * @param Int  $size
     * @access private
     * @return Int
     */
    private function computeRedLevel($size = 0)
    {
        $level = 0;
        for ($m = $size - 1; $m >= 0; $m = (int)($m/2 - 1)) {
            $level++;
        }
        return $level;
    }
    
    /**
     * The containsKey method, checks if the TreeMap contains a specific key among its key-value pairs.
     * @param Objective  $key
     * @access public
     * @return Boolean
     */
    public function containsKey(Objective $key = null)
    {
        return ($this->getEntry($key) != null);
    }
    
    /**
     * The containsValue method, checks if the TreeMap contains a specific value among its key-value pairs.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */
    public function containsValue(Objective $value = null)
    {
        for ($entry = $this->getFirstEntry(); $entry != null; $entry = $this->successor($entry)) {
            if ($this->valueEquals($value, $entry->getValue())) {
                return true;
            }
        }
        return false;
    }

    /**
     * The deleteEntry method, delete an entry at the TreeMap and then rebalances the tree.
     * @param Entry  $entry
     * @access public
     * @return Void
     */
    public function deleteEntry(Entry $entry = null)
    {
        $this->size--;
        if ($entry->getLeft() != null and $entry->getRight() != null) {
            $successor = $this->successor($entry);
            $entry->setKey($successor->getKey());
            $entry->setValue($successor->getValue());
            $entry = $successor;
        }
        $replacement = ($entry->getLeft() != null)?$entry->getLeft():$entry->getRight();
        
        if ($replacement != null) {
            $replacement->setParent($entry->getParent());
            if ($entry->getParent() == null) {
                $this->root = $replacement;
            } elseif ($entry == $entry->getParent()->getLeft()) {
                $entry->getParent()->setLeft($replacement);
            } else {
                $entry->getParent()->setRight($replacement);
            }
            
            $entry->setLeft(null);
            $entry->setRight(null);
            $entry->setParent(null);
            if ($entry->getColor() == self::BLACK) {
                $this->fixDeletion($replacement);
            }
        } elseif ($entry->getParent() == null) {
            $this->root = null;
        } else {
            if ($entry->getColor() == self::BLACK) {
                $this->fixDeletion($entry);
            }
            if ($entry->getParent() != null) {
                if ($entry == $entry->getParent()->getLeft()) {
                    $entry->getParent()->setLeft(null);
                } elseif ($entry == $entry->getParent()->getRight()) {
                    $entry->getParent()->setRight(null);
                }
                $entry->setParent(null);
            }
        }
    }
    
    /**
     * The descendingKeyIterator method, obtains a key iterator of this TreeMap in reversing order.
     * @access public
     * @return DescendingIterator
     */
    public function descendingKeyIterator()
    {
        return new DescendingKeyIterator($this, $this->getLastEntry());
    }
    
    /**
     * The descendingKeySet method, obtains a key set of this TreeMap in reversing order.
     * @access public
     * @return NavigableSettable
     */
    public function descendingKeySet()
    {
        return $this->descendingMap()->navigableKeySet();
    }

    /**
     * The descendingMap method, obtains a map in the reversing order for keys contained in this TreeMap.
     * @access public
     * @return NavigableMappable
     */
    public function descendingMap()
    {
        $map = ($this->descendingMap == null)?new DescendingSubMap($this, true, null, true, true, null, true):$this->descendingMap;
        return $map;
    }

    /**
     * The entryIterator method, acquires an instance of the EntryIterator object of this TreeMap.
     * @access public
     * @return EntryIterator
     */
    public function entryIterator()
    {
        return $this->entrySet()->iterator();
    }
    
    /**
     * The entrySet method, returns a Set of entries contained in this TreeMap.
     * @access public
     * @return EntryTreeSet
     */
    public function entrySet()
    {
        $entrySet = ($this->entrySet == null)?new EntryTreeSet($this):$this->entrySet;
        return $entrySet;
    }

    /**
     * The exportEntry method, returns an immutable entry.
     * @param Entry  $entry
     * @access public
     * @return ImmutableEntry
     */
    public function exportEntry(Entry $entry)
    {
        return new ImmutableEntry($entry);
    }
    
    /**
     * The firstEntry method, returns the entry with the least key in the Treemap.
     * @access public
     * @return MapEntry
     */
    public function firstEntry()
    {
        return $this->exportEntry($this->getFirstEntry());
    }
    
    /**
     * The firstKey method, obtains the first key object stored in this TreeMap.
     * @access public
     * @return Objective
     */
    public function firstKey()
    {
        return $this->key($this->getFirstEntry());
    }

    /**
     * The fixDeletion method, fix the Tree after deleting an Entry.
     * @param Entry  $entry
     * @access private
     * @return Void
     */
    private function fixDeletion(Entry $entry = null)
    {
        while ($entry != null and $this->colorOf($entry) == self::BLACK) {
            if ($entry == $this->leftOf($this->parentOf($entry))) {
                $sibling = $this->rightOf($this->parentOf($entry));
                if ($this->colorOf($sibling) == self::RED) {
                    $this->setColor($sibling, self::BLACK);
                    $this->setColor($this->parentOf($entry), self::RED);
                    $this->rotateLeft($this->parentOf($entry));
                    $sibling = $this->rightOf($this->parentOf($entry));
                }
                
                if ($this->colorOf($this->leftOf($sibling)) == self::BLACK and $this->colorOf($this->rightOf($sibling)) == self::BLACK) {
                    $this->setColor($sibling, self::RED);
                    $entry = $this->parentOf($entry);
                } else {
                    if ($this->colorOf($this->rightOf($sibling)) == self::BLACK) {
                        $this->setColor($this->leftOf($sibling), self::BLACK);
                        $this->setColor($sibling, self::RED);
                        $this->rotateRight($entry);
                        $sibling = $this->rightOf($this->parentOf($entry));
                    }
                    $this->setColor($sibling, $this->colorOf($this->parentOf($entry)));
                    $this->setColor($this->parentOf($entry), self::BLACK);
                    $this->setColor($this->rightOf($sibling), self::BLACK);
                    $this->rotateLeft($this->parentOf($entry));
                    $entry = $this->root;
                }
            } else {
                $sibling = $this->LeftOf($this->parentOf($entry));
                if ($this->colorOf($sibling) == self::RED) {
                    $this->setColor($sibling, self::BLACK);
                    $this->setColor($this->parentOf($entry), self::RED);
                    $this->rotateRight($this->parentOf($entry));
                    $sibling = $this->leftOf($this->parentOf($entry));
                }
                
                if ($this->colorOf($this->rightOf($sibling)) == self::BLACK and $this->colorOf($this->leftOf($sibling)) == self::BLACK) {
                    $this->setColor($sibling, self::RED);
                    $entry = $this->parentOf($entry);
                } else {
                    if ($this->colorOf($this->leftOf($sibling)) == self::BLACK) {
                        $this->setColor($this->rightOf($sibling), self::BLACK);
                        $this->setColor($sibling, self::RED);
                        $this->rotateLeft($entry);
                        $sibling = $this->leftOf($this->parentOf($entry));
                    }
                    $this->setColor($sibling, $this->colorOf($this->parentOf($entry)));
                    $this->setColor($this->parentOf($entry), self::BLACK);
                    $this->setColor($this->leftOf($sibling), self::BLACK);
                    $this->rotateRight($this->parentOf($entry));
                    $entry = $this->root;
                }
            }
        }
        $this->setColor($entry, self::BLACK);
    }
    
    /**
     * The fixInsertion method, fix the Tree after inserting an Entry.
     * @param Entry  $entry
     * @access private
     * @return Void
     */
    private function fixInsertion(Entry $entry = null)
    {
        $entry->setColor(self::RED);
        while ($entry != null and $entry != $this->root and $entry->getParent()->getColor() == self::RED) {
            if ($this->parentOf($entry) == $this->leftOf($this->parentOf($this->parentOf($entry)))) {
                $right = $this->rightOf($this->parentOf($this->parentOf($entry)));
                if ($this->colorOf($right) == self::RED) {
                    $this->setColor($this->parentOf($entry), self::BLACK);
                    $this->setColor($right, self::BLACK);
                    $this->setColor($this->parentOf($this->parentOf($entry)), self::RED);
                    $entry = $this->parentOf($this->parentOf($entry));
                } else {
                    if ($entry == $this->rightOf($this->parentOf($entry))) {
                        $entry = $this->parentOf($entry);
                        $this->rotateLeft($entry);
                    }
                    $this->setColor($this->parentOf($entry), self::BLACK);
                    $this->setColor($this->parentOf($this->parentOf($entry)), self::RED);
                    $this->rotateRight($entry);
                }
            } else {
                $left = $this->leftOf($this->parentOf($this->parentOf($entry)));
                if ($this->colorOf($left) == self::RED) {
                    $this->setColor($this->parentOf($entry), self::BLACK);
                    $this->setColor($left, self::BLACK);
                    $this->setColor($this->parentOf($this->parentOf($entry)), self::RED);
                    $entry = $this->parentOf($this->parentOf($entry));
                } else {
                    if ($entry == $this->leftOf($this->parentOf($entry))) {
                        $entry = $this->parentOf($entry);
                        $this->rotateRight($entry);
                    }
                    $this->setColor($this->parentOf($entry), self::BLACK);
                    $this->setColor($this->parentOf($this->parentOf($entry)), self::RED);
                    $this->rotateLeft($entry);
                }
            }
        }
        $this->root->setColor(self::BLACK);
    }
    
    /**
     * The floorEntry method, returns an entry associated with the greatest key less than or equal to the given key.
     * @param Objective  $key
     * @access public
     * @return MapEntry
     */
    public function floorEntry(Objective $key)
    {
        return $this->exportEntry($this->getFloorEntry($key));
    }

    /**
     * The floorKey method, acquires the greatest key less than or equal to the given key.
     * @param Objective  $key
     * @access public
     * @return Objective
     */
    public function floorKey(Objective $key)
    {
        return $this->key($this->getFloorKey($key), true);
    }
    
    /**
     * The get method, acquires the value stored in the TreeMap given its key.
     * @param Objective  $key
     * @access public
     * @return Objective
     */
    public function get(Objective $key)
    {
        $entry = $this->getEntry($key);
        return (($entry == null)?null:$entry->getValue());
    }

    /**
     * The getCeilingEntry method, gets the entry corresponding to the specific key or the least entry greater than the key.
     * @param Objective  $key
     * @access public
     * @return MapEntry
     */
    public function getCeilingEntry(Objective $key)
    {
        $entry = $this->root;
        while ($entry != null) {
            $comparison = $this->compare($key, $entry->getKey());
            if ($comparison < 0) {
                if ($entry->getLeft() != null) {
                    $entry = $entry->getLeft();
                } else {
                    return $entry;
                }
            } elseif ($comparison > 0) {
                if ($entry->getRight() != null) {
                    $entry = $entry->getRight();
                } else {
                    $parent = $entry->getParent();
                    $child = $entry;
                    while ($parent != null and $child == $parent->getRight()) {
                        $child = $parent;
                        $parent = $parent->getParent();
                    }
                    return $parent;
                }
            } else {
                return $entry;
            }
        }
        return null;
    }

    /**
     * The getDummy method, getter method for property dummy.
     * @access public
     * @return EntryTreeSet
     */
    public function getDummy()
    {
        return $this->dummy;
    }
    
    /**
     * The getEntry method, returns the entry associated with the specified key in TreeMap.
     * This is a final method, and thus can not be overriden by child class.
     * @param Objective  $key
     * @access public
     * @return MapEntry
     * @final
     */
    final public function getEntry(Objective $key)
    {
        if ($this->comparator != null) {
            return $this->getEntryComparator();
        }
        $entry = $this->root;
        while ($entry != null) {
            $comparison = $key->compareTo($entry->getKey());
            if ($comparison < 0) {
                $entry = $entry->getLeft();
            } elseif ($comparison > 0) {
                $entry = $entry->getRight();
            } else {
                return $entry;
            }
        }
        return null;
    }

    /**
     * The getEntry method, returns the entry associated with the specified key in TreeMap using comparator.
     * This is a final method, and thus can not be overriden by child class.
     * @param Objective  $key
     * @access public
     * @return MapEntry
     * @final
     */
    final public function getEntryComparator(Objective $key)
    {
        $comparator = $this->comparator;
        if ($comparator instanceof Comparative) {
            $entry = $this->root;
            $comparison = $comparator->compare($key, $entry->getKey());
            if ($comparison < 0) {
                $entry = $entry->getLeft();
            } elseif ($comparison > 0) {
                $entry = $entry->getRight();
            } else {
                return $entry;
            }
        }
        return null;
    }

    /**
     * The getFirstEntry method, returns the very first entry inside the TreeMap.
     * This is a final method, and thus can not be overriden by child class.
     * @param Objective  $key
     * @access public
     * @return MapEntry
     * @final
     */
    final public function getFirstEntry(Objective $key = null)
    {
        $entry = $this->root;
        if ($entry != null) {
            while ($entry->getLeft() != null) {
                $entry = $entry->getLeft();
            }
        }
        return $entry;
    }
    
    /**
     * The getFloorEntry method, gets the entry corresponding to the specific key or the greatest entry less than the key.
     * @param Objective  $key
     * @access public
     * @return MapEntry
     */
    public function getFloorEntry(Objective $key)
    {
        $entry = $this->root;
        while ($entry != null) {
            $comparison = $this->compare($key, $entry->getKey());
            if ($comparison > 0) {
                if ($entry->getRight() != null) {
                    $entry = $entry->getRight();
                } else {
                    return $entry;
                }
            } elseif ($comparison < 0) {
                if ($entry->getLeft() != null) {
                    $entry = $entry->getLeft();
                } else {
                    $parent = $entry->getParent();
                    $child = $entry;
                    while ($parent != null and $child == $parent->getLeft()) {
                        $child = $parent;
                        $parent = $parent->getParent();
                    }
                    return $parent;
                }
            } else {
                return $entry;
            }
        }
        return null;
    }

    /**
     * The getHigherEntry method, gets the the least entry greater than the key.
     * @param Objective  $key
     * @access public
     * @return MapEntry
     */
    public function getHigherEntry(Objective $key)
    {
        $entry = $this->root;
        while ($entry != null) {
            $comparison = $this->compare($key, $entry->getKey());
            if ($comparison < 0) {
                if ($entry->getLeft() != null) {
                    $entry = $entry->getLeft();
                } else {
                    return $entry;
                }
            } else {
                if ($entry->getRight() != null) {
                    $entry = $entry->getRight();
                } else {
                    $parent = $entry->getParent();
                    $child = $entry;
                    while ($parent != null and $child == $parent->getRight()) {
                        $child = $parent;
                        $parent = $parent->getParent();
                    }
                    return $parent;
                }
            }
        }
        return null;
    }

    /**
     * The getLastEntry method, returns the very last entry inside the TreeMap.
     * This is a final method, and thus can not be overriden by child class.
     * @access public
     * @return MapEntry
     * @final
     */
    final public function getLastEntry()
    {
        $entry = $this->root;
        if ($entry != null) {
            while ($entry->getRight() != null) {
                $entry = $entry->getRight();
            }
        }
        return $entry;
    }
    
    /**
     * The getLowerEntry method, gets the greatest entry less than the key.
     * @param Objective  $key
     * @access public
     * @return MapEntry
     */
    public function getLowerEntry(Objective $key)
    {
        $entry = $this->root;
        while ($entry != null) {
            $comparison = $this->compare($key, $entry->getKey());
            if ($comparison > 0) {
                if ($entry->getRight() != null) {
                    $entry = $entry->getRight();
                } else {
                    return $entry;
                }
            } else {
                if ($entry->getLeft() != null) {
                    $entry = $entry->getLeft();
                } else {
                    $parent = $entry->getParent();
                    $child = $entry;
                    while ($parent != null and $child == $parent->getLeft()) {
                        $child = $parent;
                        $parent = $parent->getParent();
                    }
                    return $parent;
                }
            }
        }
        return null;
    }

    /**
     * The headMap method, acquires a portion of the TreeMap ranging from the first key to the supplied key.
     * @param Objective  $toKey
     * @access public
     * @return NavigableMappable
     */
    public function headMap(Objective $toKey)
    {
        return $this->headMaps($toKey, false);
    }
    
    /**
     * The headMaps method, acquires a portion of the TreeMap ranging from the first key to the supplied key.
     * If a boolean TRUE value is supplied, the returned set will contain the supplied key at its tail.
     * @param Objective  $toKey
     * @param Boolean  $inclusive
     * @access public
     * @return AscendingSubMap
     */
    public function headMaps(Objective $toKey, $inclusive = false)
    {
        return new AscendingSubMap($this, true, null, true, false, $toKey, $inclusive);
    }
    
    /**
     * The higherEntry method, returns an entry associated with the least key strictly greater than the given key.
     * @param Objective  $key
     * @access public
     * @return MapEntry
     */
    public function higherEntry(Objective $key)
    {
        return $this->exportEntry($this->getHigherEntry($key));
    }

    /**
     * The higherKey method, acquires the least key strictly greater than the given key.
     * @param Objective  $key
     * @access public
     * @return Objective
     */
    public function higherKey(Objective $key)
    {
        return $this->key($this->getHigherKey($key), true);
    }
    
    /**
     * The key method, acquires the key corresponding to a specified Entry.
     * @param Entry  $entry
     * @param Boolean  $null
     * @access public
     * @return Objective
     */
    public function key(Entry $entry = null, $null = false)
    {
        if ($null) {
            return (($entry == null)?null:$entry->getKey());
        } else {
            if ($entry == null) {
                throw new NosuchElementException;
            }
            return $entry->getKey();
        }
    }
    
    /**
     * The keyIterator method, acquires an instance of the KeyIterator object of this TreeMap.
     * @access public
     * @return KeyTreeIterator
     */
    public function keyIterator()
    {
        return new KeyTreeIterator($this, $this->getFirstEntry());
    }

    /**
     * The keySet method, returns a Set of keys contained in this TreeMap.
     * @access public
     * @return KeySet
     */
    public function keySet()
    {
        return $this->navigableKeySet();
    }

    /**
     * The lastEntry method, returns the entry with the greatest key in the TreeMap.
     * @access public
     * @return MapEntry
     */
    public function lastEntry()
    {
        return $this->exportEntry($this->getLastEntry());
    }
    
    /**
     * The lastKey method, obtains the last key object stored in this TreeMap.
     * @access public
     * @return Objective
     */
    public function lastKey()
    {
        return $this->key($this->getLastEntry());
    }

    /**
     * The leftOf method, acquires the entry to the left of the given entry.
     * @param Entry  $entry
     * @access private
     * @return Entry
     */
    private function leftOf(Entry $entry = null)
    {
        return (($entry == null)?null:$entry->getLeft());
    }
    
    /**
     * The lowerEntry method, returns an entry associated with the greatest key strictly less than the given key.
     * @param Objective  $key
     * @access public
     * @return MapEntry
     */
    public function lowerEntry(Objective $key)
    {
        return $this->exportEntry($this->getLowerEntry($key));
    }

    /**
     * The lowerKey method, acquires the greatest key strictly less than the given key.
     * @param Objective  $key
     * @access public
     * @return Objective
     */
    public function lowerKey(Objective $key)
    {
        return $this->key($this->getLowerKey($key), true);
    }

    /**
     * The navigableKeySet method, obtains a key set of this TreeMap in the same order.
     * @access public
     * @return NavigableSettable
     */
    public function navigableKeySet()
    {
        $keySet = $this->navigableKeySet;
        return (($keySet != null)?$keySet:($this->navigableKeySet = new KeyTreeSet($this)));
    }

    /**
     * The parentOf method, obtains the parent entry to the given entry.
     * @param Entry  $entry
     * @access private
     * @return Entry
     */
    private function parentOf(Entry $entry = null)
    {
        return (($entry == null)?null:$entry->getParent());
    }
    
    /**
     * The pollFirstEntry method, retrieves and removes the entry associated with the least key in the TreeMap.
     * @access public
     * @return MapEntry
     */
    public function pollFirstEntry()
    {
        $entry = $this->getFirstEntry();
        $exportEntry = $this->exportEntry($entry);
        if ($entry != null) {
            $this->deleteEntry($entry);
        }
        return $exportEntry;
    }

    /**
     * The pollLastEntry method, retrieves and removes the entry associated with the greatest key in the TreeMap.
     * @access public
     * @return MapEntry
     */
    public function pollLastEntry()
    {
        $entry = $this->getLastEntry();
        $exportEntry = $this->exportEntry($entry);
        if ($entry != null) {
            $this->deleteEntry($entry);
        }
        return $exportEntry;
    }

    /**
     * The predecessor method, acquires the predecessor entry of the specified entry, or null if no such.
     * @param Entry  $entry
     * @access public
     * @return TreeMapEntry
     */
    public function predecessor(Entry $entry = null)
    {
        if ($entry == null) {
            return null;
        }
        if ($entry->getLeft() != null) {
            $parent = $entry->getLeft();
            while ($parent->getRight() != null) {
                $parent = $parent->getRight();
            }
        } else {
            $parent = $entry->getParent();
            $child = $entry;
            while ($parent != null and $child == $parent->getLeft()) {
                $child = $parent;
                $parent = $parent->getParent();
            }
        }
        return $parent;
    }
    
    /**
     * The put method, associates a specific value with the specific key in this TreeMap.
     * @param Objective  $key
     * @param Objective  $value
     * @access public
     * @return Objective
     */
    public function put(Objective $key = null, Objective $value = null)
    {
        $entry = $this->root;
        if ($entry == null) {
            $this->root = new TreeMapEntry($key, $value, null);
            $this->size = 1;
            return null;
        }

        $comparator = $this->comparator;
        if ($comparator != null) {
            do {
                $parent = $entry;
                $comparison = $comparator->compare($key, $entry->getKey());
                if ($comparison < 0) {
                    $entry = $entry->getLeft();
                } elseif ($comparison > 0) {
                    $entry = $entry->getRight();
                } else {
                    $entry->setValue($value);
                }
            } while ($entry != null);
        } else {
            do {
                $parent = $entry;
                $comparison = $key->compareTo($entry->getKey());
                if ($comparison < 0) {
                    $entry = $entry->getLeft();
                } elseif ($comparison > 0) {
                    $entry = $entry->getRight();
                } else {
                    $entry->setValue($value);
                }
            } while ($entry != null);
        }
        
        $newEntry = new TreeMapEntry($key, $value, $parent);
        if ($comparison < 0) {
            $parent->setLeft($newEntry);
        } else {
            $parent->setRight($newEntry);
        }
        $this->fixInsertion($newEntry);
        $this->size++;
        return null;
    }

    /**
     * The putAll method, copies all of the mappings from a specific map to this TreeMap.
     * @param Mappable  $map
     * @access public
     * @return Void
     */
    public function putAll(Mappable $map)
    {
        $size = $map->size();
        if ($this->size == 0 and $size != 0 and $map instanceof SortedMappable) {
            $this->build($size, $map->entrySet()->iterator());
        }
        parent::putAll($map);
    }

    /**
     * The remove method, removes a specific key-value pair from the TreeMap.
     * @param Objective  $key
     * @access public
     * @return Objective
     */
    public function remove(Objective $key = null)
    {
        $entry = $this->getEntry($key);
        if ($entry == null) {
            return null;
        }
        $oldValue = $entry->getValue();
        $this->deleteEntry($entry);
        return $oldValue;
    }

    /**
     * The rightOf method, acquires the entry to the right of the given entry.
     * @param Entry  $entry
     * @access private
     * @return Entry
     */
    private function rightOf(Entry $entry = null)
    {
        return (($entry == null)?null:$entry->getRight());
    }

    /**
     * The rotateLeft method, rotates an entry on the Tree to its left side.
     * @param Entry  $entry
     * @access private
     * @return Void
     */
    private function rotateLeft(Entry $entry = null)
    {
        if ($entry != null) {
            $right = $entry->getRight();
            if (!$right) {
                return;
            }
            $entry->setRight($right->getLeft());
            if ($right->getLeft() != null) {
                $right->getLeft()->setParent($entry);
            }
            $right->setParent($entry->getParent());
            
            if ($entry->getParent() == null) {
                $this->root = $right;
            } elseif ($entry->getParent()->getLeft() == $entry) {
                $entry->getParent()->setLeft($right);
            } else {
                $entry->getParent()->setRight($right);
            }
            $right->setLeft($entry);
            $entry->setParent($right);
        }
    }
    
    /**
     * The rotateRight method, rotates an entry on the Tree to its right side.
     * @param Entry  $entry
     * @access private
     * @return Void
     */
    private function rotateRight(Entry $entry = null)
    {
        if ($entry != null) {
            $left = $entry->getLeft();
            if (!$left) {
                return;
            }
            $entry->setLeft($left->getRight());
            if ($left->getRight() != null) {
                $left->getRight()->setParent($entry);
            }
            $left->setParent($entry->getParent());
            
            if ($entry->getParent() == null) {
                $this->root = $left;
            } elseif ($entry->getParent()->getRight() == $entry) {
                $entry->getParent()->setRight($left);
            } else {
                $entry->getParent()->setLeft($left);
            }
            $left->setRight($entry);
            $entry->setParent($left);
        }
    }
    
    /**
     * The setColor method, sets the color of an entry to the supplied color.
     * @param Entry  $entry
     * @access private
     * @return Void
     */
    private function setColor(Entry $entry = null, $color = self::BLACK)
    {
        if ($entry != null) {
            $entry->setColor($color);
        }
    }
    
    /**
     * The size method, returns the current size of this TreeMap.
     * @access public
     * @return Int
     */
    public function size()
    {
        return $this->size;
    }

    /**
     * The subMap method, acquires a portion of the TreeMap ranging from the supplied two keys.
     * @param Objective  $fromKey
     * @param Objective  $toKey
     * @access public
     * @return NavigableMappable
     */
    public function subMap(Objective $fromKey, Objective $toKey)
    {
        return $this->subMaps($fromKey, true, $toKey, false);
    }

    /**
     * The subMaps method, acquires a portion of the TreeMap ranging from the supplied two keys.
     * If boolean value TRUE is supplied for $inclusive, the return set will contain $fromKey and/or $toKey.
     * @param Objective  $fromKey
     * @param Boolean  $fromInclusive
     * @param Objective  $toKey
     * @param Boolean  $toInclusive
     * @access public
     * @return AscendingSubMap
     */
    public function subMaps(Objective $fromKey, $fromInclusive, Objective $toKey, $toInclusive)
    {
        return new AscendingSubMap($this, false, $fromKey, $fromInclusive, false, $toKey, $toInclusive);
    }

    /**
     * The successor method, acquires the successor entry of the specified entry, or null if no such.
     * @param Entry  $entry
     * @access public
     * @return TreeMapEntry
     */
    public function successor(Entry $entry = null)
    {
        if ($entry == null) {
            return null;
        } elseif ($entry->getRight() != null) {
            $parent = $entry->getRight();
            while ($parent->getLeft() != null) {
                $parent = $parent->getLeft();
            }
        } else {
            $parent = $entry->getParent();
            $child = $entry;
            while ($parent != null and $child == $parent->getRight()) {
                $child = $parent;
                $parent = $parent->getParent();
            }
        }
        return $parent;
    }
    
    /**
     * The tailMap method, acquires a portion of the Map ranging from the supplied key to the last key.
     * @param Objective  $fromKey
     * @access public
     * @return NavigableMappable
     */
    public function tailMap(Objective $fromKey)
    {
        return $this->tailMaps($fromKey, false);
    }

    /**
     * The tailMaps method, acquires a portion of the TreeMap ranging from the supplied key to the last key.
     * If a boolean TRUE value is supplied for $inclusive, the returned set will contain the supplied key at its head.
     * @param Objective  $fromKey
     * @param Boolean  $inclusive
     * @access public
     * @return AscendingSubMap
     */
    public function tailMaps(Objective $fromKey, $inclusive)
    {
        return new AscendingSubMap($this, false, $fromKey, $inclusive, true, null, true);
    }
    
    /**
     * The valueEquals method, evaluates if two given values are equal to each other.
     * @param Objective  $object
     * @param Objective  $object2
     * @access public
     * @return Boolean
     */
    public function valueEquals(Objective $object, Objective $object2)
    {
        return (($object == null)?($object2 == null):$object->equals($object2));
    }
    
    /**
     * The valueSet method, returns a Set of values contained in this TreeMap.
     * @access public
     * @return ValueSet
     */
    public function valueSet()
    {
        $valueSet = ($this->valueSet == null)?new ValueTreeSet($this):$this->valueSet;
        return $valueSet;
    }
}
