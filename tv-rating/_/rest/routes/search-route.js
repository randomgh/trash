import { Router } from 'express';
import dotenv from 'dotenv';

import { search } from '../controllers';

dotenv.config();

const router = new Router();

router.get('/', search.search);

export default router;