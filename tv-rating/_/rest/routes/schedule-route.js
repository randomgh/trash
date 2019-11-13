import { Router } from 'express';
import dotenv from 'dotenv';

import { schedule } from '../controllers';

dotenv.config();

const router = new Router();

router.post('/', schedule.create);
router.get('/', schedule.getAll);
router.put('/', schedule.update);
router.delete('/', schedule.delete);

router.get('/:_id', schedule.getOne);
router.put('/:_id', schedule.update);
router.delete('/:_id', schedule.delete);

export default router;