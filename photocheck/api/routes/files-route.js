import { Router } from 'express';
import dotenv from 'dotenv';

import { files } from '../controllers';

dotenv.config();

const router = new Router();

router.get('[/]?', files.getAll);
router.post('[/]?', files.create);

router.get('/:_id[/]?', files.getOne);
router.delete('/:_id[/]?', files.delete);

export default router;