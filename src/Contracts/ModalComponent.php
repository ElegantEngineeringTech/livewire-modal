<?php

declare(strict_types=1);

namespace Elegantly\LivewireModal\Contracts;

/**
 * Marks a Livewire component as allowed to be opened inside the modal manager.
 *
 * Props are sent by the browser and must be treated as untrusted input:
 * authorize them in mount() and in every action.
 */
interface ModalComponent
{
    //
}
