import { Router } from 'express';
import multer from 'multer';
import path from 'path';
import dotenv from 'dotenv';

import { user } from '../controllers';

dotenv.config();

const router = new Router(),
      upload = multer({ dest: path.resolve(__dirname, `../..${process.env.UPLOADS_DIR}/users`) });

router.post('/register', user.register);
router.put('/profile', upload.single('image'), user.profile);
router.post('/invite', user.invite);
router.get('/authenticate', user.authenticate);
router.get('/debunk', user.debunk);
router.get('/recovery', user.recovery);
router.put('/password', user.password);

export default router;