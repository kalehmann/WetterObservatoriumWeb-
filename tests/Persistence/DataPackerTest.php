<?php

/**
 *  Copyright (C) 2021 Karsten Lehmann <mail@kalehmann.de>
 *
 *  This file is part of WetterObservatoriumWeb.
 *
 *  WetterObservatoriumWeb is free software: you can redistribute it and/or
 *  modify it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, version 3 of the License.
 *
 *  WetterObservatoriumWeb is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with WetterObservatoriumWeb. If not, see
 *  <https://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace KaLehmann\WetterObservatoriumWebP\Tests\Persistence;

use KaLehmann\WetterObservatoriumWeb\Persistence\DataPacker;
use KaLehmann\WetterObservatoriumWeb\Persistence\InvalidPackFormatException;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for the DataPacker.
 */
class DataPackerTest extends TestCase
{
    /**
     * Check that valid formats do not throw exceptions.
     */
    public function testCheckFormatWithValidFormat(): void
    {
        $firstValidFormat = 'cCsSnvlLNVqQJPxX';
        $secondValidFormat = 'QlSxx';
        $thirdValidFormat = 'cX';

        $this->assertTrue(
            DataPacker::checkFormat($firstValidFormat)
        );
        $this->assertTrue(
            DataPacker::checkFormat($secondValidFormat)
        );
        $this->assertTrue(
            DataPacker::checkFormat($thirdValidFormat)
        );
    }

    /**
     * Check that invalid formats throw an exception.
     */
    public function testCheckInvalidFormat(): void
    {
        $invalidFormat = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz';

        $this->expectException(InvalidPackFormatException::class);
        $this->expectExceptionMessage(
            'A, a, B, b, D, d, E, e, F, f, G, g, H, h, I, i, j, K, k, M, m, ' .
            'O, o, p, R, r, T, t, U, u, W, w, Y, y, Z, z',
        );
        DataPacker::checkFormat($invalidFormat);
    }

    /**
     * Check that the getElementSize method throws an exception for an invalid
     * format.
     */
    public function testGetElementSizeWithInvalidFormat(): void
    {
        $invalidFormat = 'invalid';
        $this->expectException(InvalidPackFormatException::class);
        $this->expectExceptionMessage(
            'i, a, d',
        );

        DataPacker::getElementSize($invalidFormat);
    }

    /**
     * Check that the getElementSize method correctly determines the data size
     * from a pack format.
     */
    public function testGetElementSizeWithValidFormat(): void
    {
        $this->assertEquals(
            12,
            DataPacker::getElementSize('QL'),
        );

        $this->assertEquals(
            4,
            DataPacker::getElementSize('cXcX'),
        );
        $this->assertEquals(
            strlen(
                pack('qcxxS', -2**16, 'a', 42),
            ),
            DataPacker::getElementSize('qcxxS'),
        );
    }

     /**
     * Check that the getFormatElementCount method throws an exception for an
     * invalid format.
     */
    public function testGetFormatElementCountWithInvalidFormat(): void
    {
        $invalidFormat = 'invalid';
        $this->expectException(InvalidPackFormatException::class);
        $this->expectExceptionMessage(
            'i, a, d',
        );

        DataPacker::getFormatElementCount($invalidFormat);
    }

    /**
     * Check that the number of Elements in a format is correctly determined.
     */
    public function testGetFormatElementCountWithValidFormat(): void
    {
        $this->assertEquals(
            0,
            DataPacker::getFormatElementCount('xxX'),
        );
        $this->assertEquals(
            14,
            DataPacker::getFormatElementCount('cCsSnvlLNVqQJPxX'),
        );
    }
}
