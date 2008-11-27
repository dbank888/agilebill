<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Image_Graph - PEAR PHP OO Graph Rendering Utility.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This library is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation; either version 2.1 of the License, or (at your
 * option) any later version. This library is distributed in the hope that it
 * will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
 * General Public License for more details. You should have received a copy of
 * the GNU Lesser General Public License along with this library; if not, write
 * to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 * 02111-1307 USA
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Dataset
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id: VectorFunction.php,v 1.6 2005/08/24 20:35:57 nosey Exp $
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Dataset.php
 */
require_once 'Image/Graph/Dataset.php';

/**
 * Vector Function data set.
 *
 * Points are generated by calling 2 external functions, fx. x = sin(t) and y =
 * cos(t)
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Dataset
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_Dataset_VectorFunction extends Image_Graph_Dataset
{

    /**
     * The name of the X function
     * @var string
     * @access private
     */
    var $_functionX;

    /**
     * The name of the Y function
     * @var string
     * @access private
     */
    var $_functionY;

    /**
     * The minimum of the vector function variable
     * @var double
     * @access private
     */
    var $_minimumT;

    /**
     * The maximum of the vector function variable
     * @var double
     * @access private
     */
    var $_maximumT;

    /**
     * Image_Graph_VectorFunctionDataset [Constructor]
     *
     * @param double $minimumT The minimum value of the vector function variable
     * @param double $maximumT The maximum value of the vector function variable
     * @param string $functionX The name of the X function, if must be a single
     *   parameter function like fx sin(x) or cos(x)
     * @param string $functionY The name of the Y function, if must be a single
     *   parameter function like fx sin(x) or cos(x)
     * @param int $points The number of points to create
     */
    function Image_Graph_Dataset_VectorFunction($minimumT, $maximumT, $functionX, $functionY, $points)
    {
        parent::Image_Graph_Dataset();
        $this->_minimumT = $minimumT;
        $this->_maximumT = $maximumT;
        $this->_functionX = $functionX;
        $this->_functionY = $functionY;
        $this->_count = $points;
        $this->_calculateMaxima();
    }

    /**
     * Add a point to the dataset
     *
     * @param int $x The X value to add
     * @param int $y The Y value to add, can be omited
     * @param var $ID The ID of the point
     */
    function addPoint($x, $y = false, $ID = false)
    {
    }

    /**
     * Gets a X point from the dataset
     *
     * @param var $x The variable to apply the X function to
     * @return var The X function applied to the X value
     * @access private
     */
    function _getPointX($x)
    {
        $functionX = $this->_functionX;
        return $functionX ($x);
    }

    /**
     * Gets a Y point from the dataset
     *
     * @param var $x The variable to apply the Y function to
     * @return var The Y function applied to the X value
     * @access private
     */
    function _getPointY($x)
    {
        $functionY = $this->_functionY;
        return $functionY ($x);
    }

    /**
     * Reset the intertal dataset pointer
     *
     * @return var The first T value
     * @access private
     */
    function _reset()
    {
        $this->_posX = $this->_minimumT;
        return $this->_posX;
    }

    /**
     * The interval between 2 adjacent T values
     *
     * @return var The interval
     * @access private
     */
    function _stepX()
    {
        return ($this->_maximumT - $this->_minimumT) / $this->count();
    }

    /**
     * Calculates the X and Y extrema of the functions
     *
     * @access private
     */
    function _calculateMaxima()
    {
        $t = $this->_minimumT;
        while ($t <= $this->_maximumT) {
            $x = $this->_getPointX($t);
            $y = $this->_getPointY($t);
            $this->_minimumX = min($x, $this->_minimumX);
            $this->_maximumX = max($x, $this->_maximumX);
            $this->_minimumY = min($y, $this->_minimumY);
            $this->_maximumY = max($y, $this->_maximumY);
            $t += $this->_stepX();
        }
    }

}

?>