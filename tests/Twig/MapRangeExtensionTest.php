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

namespace KaLehmann\WetterObservatoriumWeb\tests\Twig;

use KaLehmann\WetterObservatoriumWeb\Twig\MapRangeExtension;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for the MapRangeExtension.
 */
class MapRangeExtensionTest extends TestCase
{
    /**
     * Check that a number can be mapped from one range to another.
     */
    public function testMapRange(): void
    {
        $this->assertEquals(
            50,
            MapRangeExtension::mapRange(5, 0, 10, 0, 100),
        );
        $this->assertEquals(
            20,
            MapRangeExtension::mapRange(10, 5, 30, 10, 60),
        );
    }
}