<?php

namespace App\Domains\Framework\Component\Components;

use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Component\Components\Button\Button;
use App\Domains\Framework\Core\Utilities\ExportBuilder;
use Domain\Integration\Models\Integration;
use Exception;

class ShopConnectionPanel extends Component
{
	private Button|null $acceptButton = null;

	private string|null $permissionsText = null;

	public function __construct(private Integration $integration)
	{
	}

	public static function make(Integration $integration): self
	{
		return new self($integration);
	}

	/**
	 * @param Button|null $acceptButton
	 * @return static
	 */
	public function setAcceptButton(Button|null $acceptButton)
	{
		$this->acceptButton = $acceptButton;

		return $this;
	}

	/**
	 * @param string $permissionsText
	 * @return static
	 */
	public function setPermissionsText(string $permissionsText)
	{
		$this->permissionsText = $permissionsText;

		return $this;
	}

	/**
	 * @throws Exception
	 */
	public function export(): array
	{
		$integrationHandler = $this->integration->getHandler();

		return ExportBuilder::make($this)
			->addProperty("integrationName", $this->integration->name)
			->addProperty("integrationLogoUrl", $integrationHandler->getLogo())
			->addProperty(
				"permissions",
				$integrationHandler->getConnectionPermissionTexts()
			)
			->addProperty("acceptButton", $this->acceptButton)
			->addProperty("permissionsText", __($this->permissionsText))
			->export();
	}
}
