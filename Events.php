<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle;

final class Events
{
    const BEFORE_PRESIGN = 'presigned_filemanager.before_presign';

    const AFTER_PRESIGN = 'presigned_filemanager.after_presign';

    const BEFORE_POST_UPLOAD = 'presigned_filemanager.before_post_upload';

    const AFTER_POST_UPLOAD = 'presigned_filemanager.after_post_upload';
}
