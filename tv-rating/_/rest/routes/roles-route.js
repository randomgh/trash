import { Router } from 'express';
import dotenv from 'dotenv';

import { roles } from '../controllers';

dotenv.config();

const router = new Router();

router.post('/', roles.create);
router.get('/', roles.getAll);
router.put('/', roles.update);
router.delete('/', roles.delete);

router.get('/:_id', roles.getOne);
router.put('/:_id', roles.update);
router.delete('/:_id', roles.delete);

export default router;