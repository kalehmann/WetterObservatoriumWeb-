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

namespace KaLehmann\WetterObservatoriumWeb\Persistence;

use \Exception;
use function array_unique;
use function join;

/**
 * Exception for anything related to reading and writing data.
 */
class InvalidPackFormatException extends Exception
{
    public function __construct(string ...$codes)
    {
        parent::__construct(
            'Only pack formats with a known length are supported. ' .
            'See ' . DataPacker::class . '::ALLOWED_FORMATS for a full list ' .
            'of the allowed formats. The following unknown/non-fixed-length ' .
            'format codes were detected : ' .
            join(
                ', ',
                array_unique($codes),
            ),
        );
    }
}