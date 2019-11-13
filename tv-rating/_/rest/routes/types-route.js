import { Router } from 'express';
import dotenv from 'dotenv';

import { types } from '../controllers';

dotenv.config();

const router = new Router();

router.post('/', types.create);
router.get('/', types.getAll);
router.put('/', types.update);
router.delete('/', types.delete);

router.get('/:_id', types.getOne);
router.put('/:_id', types.update);
router.delete('/:_id', types.delete);

export default router;