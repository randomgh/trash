import { Router } from 'express';
import dotenv from 'dotenv';

import { reports } from '../controllers';

dotenv.config();

const router = new Router();

router.get('[/]?', reports.getAll);
router.post('[/]?', reports.create);

router.get('/:_id[/]?', reports.getOne);
router.delete('/:_id[/]?', reports.delete);

export default router;