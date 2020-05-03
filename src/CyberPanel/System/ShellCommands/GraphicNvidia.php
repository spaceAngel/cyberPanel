<?php

namespace CyberPanel\System\ShellCommands;

interface GraphicNvidia {

	const CMD_TEMP = 'nvidia-smi --query-gpu=temperature.gpu --format=csv,noheader';

	const CMD_LOAD = 'nvidia-smi --query-gpu=utilization.gpu --format=csv,noheader';

	const CMD_MEMORY_TOTAL = 'nvidia-smi --query-gpu=memory.total --format=csv,noheader';

	const CMD_MEMORY_FREE = 'nvidia-smi --query-gpu=memory.free --format=csv,noheader';

}
