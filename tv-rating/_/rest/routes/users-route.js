import { Router } from 'express';
import multer from 'multer';
import path from 'path';
import dotenv from 'dotenv';

import { users } from '../controllers';

dotenv.config();

const router = new Router(),
      upload = multer({ dest: path.resolve(__dirname, `../..${process.env.UPLOADS_DIR}/users`) });

router.post('/', upload.single('image'), users.create);
router.get('/', users.getAll);
router.put('/', upload.single('image'), users.update);
router.delete('/', users.delete);

router.get('/:_id', users.getOne);
router.put('/:_id', upload.single('image'), users.update);
router.delete('/:_id', users.delete);

export default router;