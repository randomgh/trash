import { Router } from 'express';
import dotenv from 'dotenv';

import { parsers } from '../controllers';

dotenv.config();

const router = new Router();

router.get('/:_id', parsers.parse);
router.get('/:_id.:method(types|genres|roles|channels|broadcasts|persons)', parsers.parse);

export default router;