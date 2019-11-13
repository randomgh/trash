import { Router } from 'express';
import dotenv from 'dotenv';

import { methods } from '../controllers';

dotenv.config();

const router = new Router();

router.get('[/]?', methods.getAll);
router.post('[/]?', methods.create);

router.get('/:_id[/]?', methods.getOne);
router.delete('/:_id[/]?', methods.delete);

export default router;