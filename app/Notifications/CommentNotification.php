<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CommentNotification extends Notification
{
    use Queueable;

    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    // Which channels to use
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    // Email content
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Comment on Your Post')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($this->comment->user->name . ' commented on your post: "' . $this->comment->post->title . '"')
            ->line('Comment: ' . $this->comment->content)
            ->action('View Post', url('/api/posts/' . $this->comment->post_id))
            ->line('Thank you for using our application!');
    }

    // Database storage
    public function toDatabase($notifiable)
    {
        return [
            'comment_id' => $this->comment->id,
            'post_id' => $this->comment->post_id,
            'commenter_name' => $this->comment->user->name,
            'comment_content' => $this->comment->content,
            'message' => $this->comment->user->name . ' commented on your post'
        ];
    }

    // Define notification type
    public function databaseType()
    {
        return 'new_comment';
    }
}
