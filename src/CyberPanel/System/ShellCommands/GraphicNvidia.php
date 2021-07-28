<?php

namespace CyberPanel\System\ShellCommands;

interface GraphicNvidia {

	// phpcs:disable Generic.Files.LineLength
	const CMD_GETINFO = 'nvidia-smi --query-gpu=temperature.gpu,utilization.gpu,memory.total,memory.free --format=csv,noheader';
	// phpcs:enable

	const CMD_GPUNAME = 'nvidia-smi --query-gpu=gpu_name --format=csv,noheader';

}
